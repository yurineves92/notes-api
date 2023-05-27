<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test if a user can login successfully by sending a POST request to the "login" route.
     *
     * @return void
     */
    public function testUserCanLogin()
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->post(route('auth.login'), [
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'token' => $response->json('token'),
            'user' => [
                'id' => $user->id,
                'name' => 'test',
                'email' => 'test@example.com',
                'created_at' => $user->created_at->toISOString(),
                'updated_at' => $user->updated_at->toISOString(),
            ]
        ]);
    }

    /**
     * Test if an unauthenticated user receives an error when trying to access authenticated routes.
     *
     * @return void
     */
    public function testUnauthenticatedUserCannotAccessAuthenticatedRoutes()
    {
        // Simulate unauthenticated user by not sending any authentication token
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(route('user.profile'));

        $response->assertStatus(401);
        // Add other assertions for the error response here
    }
}
