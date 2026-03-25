<?php

namespace Modules\Api\Http\Controllers\V1\Auth;

use Modules\Api\Http\Controllers\BaseApiController;
use Modules\Api\Http\Requests\Auth\LoginRequest;
use Modules\Api\Resources\Auth\AuthResource;
use Modules\Api\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseApiController
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
