<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'body' => $this->faker->sentence,
            'status' => 1,
            'color_status' => $this->faker->hexColor,
            'status_log' => [],
        ];
    }
}
