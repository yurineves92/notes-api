<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return response()->json(["user" => $user], 200);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (empty($user)) {
            return response()->json(
                [
                    "data" => [
                        "message" => "Usuário não encontrado.",
                    ],
                ],
                200
            );
        }
        $user->name = $request->name;
        $user->save();
        return response()->json(
            [
                "data" => [
                    "message" => "Suas informações foram atualizadas.",
                    "data" => $user,
                ],
            ],
            200
        );
    }
}
