<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStatusTest extends TestCase {
    use RefreshDatabase;

    public function test_inactive_user_cannot_login() {
        // Create an inactive user
        $user = User::factory()->create([
            'status' => 'inactive',
            'password' => bcrypt('password123')
        ]);

        // Attempt to login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123'
        ]);

        // Should redirect back with error
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_active_user_can_login() {
        // Create an active user
        $user = User::factory()->create([
            'status' => 'active',
            'password' => bcrypt('password123')
        ]);

        // Attempt to login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123'
        ]);

        // Should redirect to dashboard
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_inactive_user_is_logged_out_during_browsing() {
        // Create and login an active user
        $user = User::factory()->create([
            'status' => 'active',
            'password' => bcrypt('password123')
        ]);

        $this->actingAs($user);

        // Verify user is authenticated
        $this->assertAuthenticated();

        // Change user status to inactive
        $user->update(['status' => 'inactive']);

        // Try to access dashboard (should trigger middleware)
        $response = $this->get('/dashboard');

        // Should be redirected to login with error
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}
