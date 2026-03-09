<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Resources\Auth\AuthResource;
use App\Services\Api\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());
        return $this->sendResponse(new AuthResource($result), 'Muvaffaqiyatli kirildi.');
    }

    /**
     * Get the authenticated user.
     */
    public function me(Request $request)
    {
        $result = $this->authService->me($request);
        return $this->sendResponse(new AuthResource($result), 'Foydalanuvchi ma\'lumotlari.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->sendResponse([], 'Muvaffaqiyatli chiqildi.');
    }
}
