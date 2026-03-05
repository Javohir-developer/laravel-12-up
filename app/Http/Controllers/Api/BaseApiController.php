<?php
// app/Http/Controllers/Api/BaseApiController.php
namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected function sendResponse(mixed $result): JsonResponse
    {
        if (!$result && !is_array($result)) {
            return response()->json([
                'success'  => false,
                'messages' => ['Xatolik yuz berdi'],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data'    => $result,
        ]);
    }

    protected function sendModel(mixed $model): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $model,
        ]);
    }

    protected function sendError(array $messages, int $status = 422): JsonResponse
    {
        return response()->json([
            'success'  => false,
            'messages' => $messages,
        ], $status);
    }
}