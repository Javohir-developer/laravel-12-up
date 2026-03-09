<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Auth\ApiLoginRequest;
use App\Services\Api\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseApiController
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Handle an incoming authentication request.
     */
    public function login(ApiLoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return $this->sendResponse($result, 'Muvaffaqiyatli kirildi.');
    }

    /**
     * Get the authenticated user.
     */
    public function me(Request $request)
    {
        $result = $this->authService->me($request);
        return $this->sendResponse($result, 'Foydalanuvchi ma\'lumotlari.');
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
