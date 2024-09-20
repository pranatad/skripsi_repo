<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        // Create a user
        $user = User::create([
            'username' => 'superadmin',
            'password' => Hash::make('admin'),
        ]);

        // Attempt to login
        $response = $this->post('/login', [
            'username' => 'superadmin',
            'password' => 'admin',
        ]);

        // Assert the user is redirected to the home page
        $response->assertRedirect('/home');
    }

    /** @test */
    public function user_cannot_login_with_incorrect_credentials()
    {
        // Create a user
        $user = User::create([
            'username' => 'superadmin',
            'password' => Hash::make('admin'),
        ]);

        // Attempt to login with wrong password
        $response = $this->post('/login', [
            'username' => 'superadmin',
            'password' => 'wrongpassword',
        ]);

        // Assert the user is redirected back to the login page
        $response->assertSessionHasErrors();
        $response->assertRedirect('/');
    }
}
