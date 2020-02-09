<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
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
        $token = \Hash::make(\Str::random(80));

        $request->user()->fill([
            'api_token' => $token,
        ])->save();

        return response()->json(['token' => $token]);
    }

}
