<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalContentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_legal_content_editor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/legal-content');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_open_legal_content_editor(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/legal-content');

        $response->assertStatus(403);
    }

    public function test_admin_can_update_legal_content(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = config('legal');
        $payload['project']['project_name'] = 'Bersahaja Web Baru';

        $response = $this->actingAs($admin)->put('/admin/legal-content', $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('site_settings', [
            'key' => 'legal_content',
        ]);
        $this->assertSame('Bersahaja Web Baru', SiteSetting::getValue('legal_content')['project']['project_name']);
    }
}
