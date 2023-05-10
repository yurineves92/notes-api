<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        $token = $user->createToken("notes-api")->accessToken;

        return response()->json(
            [
                "data" => [
                    "message" => "Usuário criado com sucesso.",
                    "token" => $token
                ],
            ],
            201
        );
    }

    public function login(Request $request)
    {
        $data = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken("notes-api")->accessToken;
            return response()->json(["user" => $user, "token" => $token], 200);
        } else {
            return response()->json(["error" => "Não autorizado."], 401);
        }
    }
}
