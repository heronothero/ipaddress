<?php declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthorizationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that user can login
     */
    public function user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);
        $response = $this->post('/authorization', [
            'email' => $user->email,
            'password' => 'password123',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    /**
     * Test that user cant login with incorrect credentials
     */
    public function user_cannot_login_with_incorrect_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);
        $response = $this->post('/authorization', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);
        $response->assertRedirect('/authorization');
        $this->assertGuest();
    }
}
