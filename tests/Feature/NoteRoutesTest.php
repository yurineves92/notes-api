<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NoteRoutesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test retrieving the list of notes.
     *
     * @return void
     */
    public function testRetrieveListOfNotes()
    {
        $user = User::factory()->create();
        $token = $user->createToken("notes-api")->accessToken;

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get(route('notes.index'));

        $response->assertStatus(200);
        // Add assertions for the expected response data here
    }

    /**
     * Test creating a new note.
     *
     * @return void
     */
    public function testCreateNewNote()
    {
        $user = User::factory()->create();
        $token = $user->createToken("notes-api")->accessToken;

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post(route('notes.store'), [
            'user_id' => $user->id,
            'body' => 'Example',
            'status' => 1,
            'color_status' => "#FFFFFF",
            'status_log' => []
        ]);

        $response->assertStatus(201);
        // Add assertions for the expected response data here
    }

    /**
     * Test updating the status of a note.
     *
     * @return void
     */
    public function testUpdateNoteStatus()
    {
        $user = User::factory()->create();
        $token = $user->createToken("notes-api")->accessToken;

        $note = Note::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->patch(route('notes.updateStatus', ['id' => $note->id]), [
            // Add the data for updating the note status
        ]);

        $response->assertStatus(200);
        // Add assertions for the expected response data here
    }

    /**
     * Test deleting a note.
     *
     * @return void
     */
    public function testDeleteNote()
    {
        $user = User::factory()->create();
        $token = $user->createToken("notes-api")->accessToken;

        $note = Note::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete(route('notes.destroy', ['id' => $note->id]));

        $response->assertStatus(204);
        // Add assertions for the expected response data here
    }
}
