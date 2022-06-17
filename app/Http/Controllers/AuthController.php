<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\DTO\RegisterDTO;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse {
        $registerDTO = RegisterDTO::fromRequest($request);

        try {
            $user = User::create([
                'firstname' => $registerDTO->firstname,
                'lastname' => $registerDTO->lastname,
                'email' => $registerDTO->email,
                'password' => $registerDTO->password
            ]);

            $token = Auth::login($user);

            return response()->json([
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse {

        $user = User::query()
            ->where('email', $request->get('email'))
            ->whereRaw('password = '.$request->get('password'))
            ->first();

        if(!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = Auth::login($user);

        if(!$token) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout(): JsonResponse {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
