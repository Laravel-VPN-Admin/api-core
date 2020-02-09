<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorizationController extends Controller
{
    /**
     * Login user by provided details
     *
     * @param \App\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Fetch User
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        // If user is not found
        if (!$user instanceof User) {
            return response()->json(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Verify the password
        if (password_verify($request->password, $user->password)) {
            return response()->json(['token' => $user->api_token]);
        }

        return response()->json(['message' => 'Invalid credentials'], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Refresh API token
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        $token = Str::random(60);

        dd($request->user());
        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return response()->json(['token' => $token]);
    }

}
