<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'accept_terms' => 'on',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_registration_is_rate_limited_after_too_many_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/register', []);
        }

        $response = $this->post('/register', []);

        $response->assertStatus(429);
        $this->assertGuest();
    }

    public function test_new_user_must_accept_terms_to_register(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'terms@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'accept_terms' => false,
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('accept_terms');
        $this->assertGuest();
    }
}
