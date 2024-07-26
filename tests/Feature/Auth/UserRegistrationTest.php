<?php declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that user can register with specific IP
     */
    public function testUserRegistrationWithSpecificIP()
{
    $ipAddress = '127.0.0.1';
    $response = $this->post('/registration', [
        'name' => 'Johni Doe',
        'email' => 'john.doe@example.com',
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

    /**
     * Test that user can register
     */
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
