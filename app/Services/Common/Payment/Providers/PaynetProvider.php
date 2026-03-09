<?php

namespace App\Services\Common\Payment\Providers;

use App\Models\Card;
use App\Models\Transaction;
use App\Services\Common\Payment\Contracts\PaymentProviderInterface;
use Illuminate\Http\Request;

class PaynetProvider implements PaymentProviderInterface
{
    public function addCard(int $userId, string $cardNumber, string $expire): array
    {
        throw new \Exception('Paynet provider addCard not implemented yet');
    }

    public function verifyCard(int $cardId, string $token, string $code): Card
    {
        throw new \Exception('Paynet provider verifyCard not implemented yet');
    }

    public function initiatePayment(int $orderId, int $cardId, int $userId): Transaction
    {
        throw new \Exception('Paynet provider initiatePayment not implemented yet');
    }

    public function cancelPayment(int $transactionId): Transaction
    {
        throw new \Exception('Paynet provider cancelPayment not implemented yet');
    }

    public function handleWebhook(Request $request): \Illuminate\Http\JsonResponse
    {
        throw new \Exception('Paynet provider handleWebhook not implemented yet');
    }
}
