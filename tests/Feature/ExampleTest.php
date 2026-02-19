<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_terms_page_can_be_rendered(): void
    {
        $response = $this->get('/terms-and-conditions');

        $response->assertStatus(200);
    }

    public function test_privacy_page_can_be_rendered(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertStatus(200);
    }
}
