<?php

namespace App\Services\Common\Payment\Contracts;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Http\Request;

interface PaymentProviderInterface
{
    /**
     * Karta qo'shish jarayonini boshlash
     */
    public function addCard(int $userId, string $cardNumber, string $expire): array;

    /**
     * Kartani OTP kod orqali tasdiqlash
     */
    public function verifyCard(int $cardId, string $token, string $code): Card;

    /**
     * To'lovni boshlash (transaction yaratish/chek yaratish va to'lash)
     */
    public function initiatePayment(int $orderId, int $cardId, int $userId): Transaction;

    /**
     * To'lovni bekor qilish
     */
    public function cancelPayment(int $transactionId): Transaction;

    /**
     * Webhook so'rovlarni qabul qilish
     */
    public function handleWebhook(Request $request): \Illuminate\Http\JsonResponse;
}
