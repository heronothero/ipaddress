<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    public function testUserRegistrationWithSpecificIP()
{
    $ipAddress = '24.48.0.1';
    $response = $this->post('/registration', [
        'name' => 'Johnie Doe',
        'email' => 'johnie.doe@example.com',
        'password' => 'password1111',
        'password_confirmation' => 'password1111',
        'ip' => $ipAddress,
    ]);
    $response->assertStatus(302);
    $response->assertRedirect('/');
    $this->assertDatabaseHas('users', [
        'email' => 'john.doe@example.com',
        'ip' => $ipAddress,
    ]);
    }
    public function testUserRegistration()
{
    $response = $this->post('/registration', [
        'name' => 'Jane',
        'email' => 'jane.doe@example.com',
        'password' => 'password1111',
        'password_confirmation' => 'password1111',
    ]);
    $response->assertStatus(302);
    $response->assertRedirect('/');
    $this->assertDatabaseHas('users', [
        'email' => 'jane.doe@example.com',
    ]);
    }
}
