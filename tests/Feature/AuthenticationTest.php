<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if a user can login successfully by sending a POST request to the "login" route.
     *
     * @return void
     */
    public function testUserCanLogin()
    {
        $user = Factory::factoryForModel(User::class)->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'token_type' => 'Bearer',
            // Add other expected response data here
        ]);
    }

    /**
     * Test if an unauthenticated user receives an error when trying to access authenticated routes.
     *
     * @return void
     */
    public function testUnauthenticatedUserCannotAccessAuthenticatedRoutes()
    {
        $response = $this->get(route('user.profile'));

        $response->assertStatus(401);
        // Add other assertions for the error response here
    }
}
