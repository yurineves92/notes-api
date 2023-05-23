<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'body', 'status']);
        $notes = Note::query()->filter($filters)->get();
        return response()->json(
            [
                "data" => [
                    "notes" => $notes,
                ],
            ],
            200
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'body' => 'required',
            'status' => 'required',
            'color_status' => 'required',
            'status_log' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_array($value) || empty($value)) {
                        $fail("O campo {$attribute} deve ser um array JSON válido com pelo menos um elemento.");
                    } else {
                        foreach ($value as $element) {
                            if (!isset($element['status']) || !isset($element['timestamp'])) {
                                $fail("O campo {$attribute} deve conter elementos com as chaves 'status' e 'timestamp'.");
                                break;
                            }
                        }
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $validator->errors(),
            ], 422);
        }

        $requestData = $request->all();
        $requestData['status_log'] = json_encode($requestData['status_log']);

        $note = Note::create($requestData);

        if ($note) {
            return response()->json([
                'message' => 'Nota criada com sucesso.',
                'data' => $note,
            ], 201);
        } else {
            return response()->json([
                'error' => 'Erro ao criar a nota.',
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $note = Note::find($id);

        if ($note === null) {
            return response()->json([
                'message' => 'Não foi possível encontrar a nota para atualizar.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Erro de validação',
                'message' => $validator->errors(),
            ], 422);
        }

        $newStatus = $request->input('status');
        $timestamp = now();

        $note->status = $newStatus;
        $note->save();

        $note->addStatusLog($newStatus, $timestamp);

        return response()->json([
            'message' => 'Status atualizado com sucesso.',
            'data' => $note,
        ], 200);
    }

    public function destroy($id)
    {
        try {
            Note::findOrFail($id)->delete();
            return response()->json([
                'message' => 'Nota removida com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível excluir a nota ou não existe.'], 404);
        }
    }
}
