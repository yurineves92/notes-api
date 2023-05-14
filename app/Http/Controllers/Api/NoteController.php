<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'body', 'status']);
        $notes = Note::where('user_id', '=', Auth::user()->id)->get();
        return response()->json(
            [
                "data" => [
                    "notes" => $notes,
                ],
            ],
            200
        );
    }
}
