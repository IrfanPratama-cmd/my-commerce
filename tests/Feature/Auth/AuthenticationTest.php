<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

       /** @test */
    public function it_redirects_to_index_on_successful_login()
    {
        $data = [
            'name' => 'Test Name',
            'email' => 'test@example.com',
            'role_id' => 1,
            'password' => bcrypt('password123'),
        ];

        $user = User::create($data);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/')
            ->assertSessionHas('success', 'Login Successfull');

        $this->assertAuthenticatedAs($user);

        User::where('email', 'test@example.com')->delete();
    }

    /** @test */
    public function it_redirects_to_login_with_error_on_failed_login()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login')
            ->assertSessionHas('error', 'Login Gagal!, Email atau Password anda salah!.');
    }

    /** @test */
    public function testLogout()
    {
        // Simulate a user logged in
        $user = User::where('email', 'admin@gmail.com')->first();
        $this->actingAs($user);

        // Perform logout
        $response = $this->get('/logout');

        // Assert that user is redirected to login page after logout
        $response->assertRedirect('/login');

        // Assert that user is logged out
        $this->assertFalse(Auth::check());
    }
}
