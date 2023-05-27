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

        $data = [
            'user_id' => $user->id,
            'body' => 'Conteúdo da nota',
            'status' => 1,
            'color_status' => '#FF0000',
            'status_log' => [
                [
                    'status' => 1,
                    'timestamp' => '2023-05-14 10:00:00'
                ]
            ]
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->json('POST', route('notes.store'), $data);

        $response->assertStatus(201);
    }

    public function testUpdateNoteStatus()
    {
        $user = User::factory()->create();
        $token = $user->createToken("notes-api")->accessToken;
        $note = Note::factory()->create(['user_id' => $user->id]);

        $data = [
            'status_log' => [
                [
                    'status' => 2,
                    'timestamp' => now()->format('Y-m-d H:i:s'),
                ],
            ],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->json('PATCH', route('notes.updateStatus', ['id' => $note->id]), $data);

        $response->assertStatus(200);
        // Adicione asserções para os dados de resposta esperados aqui
    }

    public function testDeleteNote()
    {
        $user = User::factory()->create();
        $token = $user->createToken("notes-api")->accessToken;

        $note = Note::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->json('DELETE', route('notes.destroy', ['id' => $note->id]));

        $response->assertStatus(200);
        // Adicione asserções para os dados de resposta esperados aqui
    }
}