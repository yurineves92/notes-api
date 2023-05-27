<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserRoutesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test if a user can retrieve their profile.
     *
     * @return void
     */
    public function testRetrieveUserProfile()
    {
        $user = User::factory()->create();

        $token = $user->createToken("notes-api")->accessToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get(route('user.profile'));

        $response->assertStatus(200);
        // Add assertions for the expected response data here
    }

    /**
     * Test if a user can update their profile.
     *
     * @return void
     */
    public function testUpdateUserProfile()
    {
        $user = User::factory()->create();

        $token = $user->createToken("notes-api")->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put(route('user.update'), [
            'name' => 'New Name',
            // Add other fields to be updated in the user profile
        ]);

        $response->assertStatus(200);
        // Add assertions for the expected response data here
    }
}
