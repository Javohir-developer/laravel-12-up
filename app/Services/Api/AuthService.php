<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Perform API login and return token and user data.
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $token = $user->createToken($data['device_name'])->plainTextToken;

        return [
            'token' => $token,
            'user' => array_merge(
                $user->only(['id', 'name', 'email']),
                ['roles' => $user->getRoleNames()]
            ),
        ];
    }

    /**
     * Get profile data for the authenticated user.
     *
     * @param Request $request
     * @return array
     */
    public function me(Request $request): array
    {
        $user = $request->user();
        return [
            'user' => array_merge(
                $user->only(['id', 'name', 'email']),
                ['roles' => $user->getRoleNames()]
            ),
            'token' => $request->bearerToken(),
        ];
    }

    /**
     * Log the user out by deleting the current access token.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
