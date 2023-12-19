<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\UserProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

   /** @test */
   public function user_can_register()
   {
       $userData = [
           'name' => 'John Doe',
           'email' => 'john@example.com',
           'password' => 'password123',
       ];

       $request = new Request($userData);

       $response = $this->post('/register', $userData); // Asumsi route '/register' digunakan

       $response->assertRedirect('/login');
       $response->assertSessionHas('success', 'Register user successfully');

       // Assertions for database records, if needed
       $this->assertDatabaseHas('users', [
           'name' => 'John Doe',
           'email' => 'john@example.com',
       ]);

      $user = User::where('email', 'john@example.com')->first();
      UserProfile::where('user_id', $user->id)->delete();
      $user->delete();
   }
}
