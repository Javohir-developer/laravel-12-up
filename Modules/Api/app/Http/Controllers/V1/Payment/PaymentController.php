<?php

namespace Modules\Api\Http\Controllers\V1\Payment;

use Modules\Api\Http\Controllers\BaseApiController;
use Modules\Api\Http\Requests\Payment\CardCreateRequest;
use Modules\Api\Http\Requests\Payment\CardVerifyRequest;
use Modules\Api\Http\Requests\Payment\PaymentRequest;
use Modules\Api\Services\Payment\PaymentFactory;
use Illuminate\Http\Request;

class PaymentController extends BaseApiController
{
    public function __construct(
        private PaymentFactory $paymentFactory
    ) {}

    // QADAM 1: Karta qo'shish
    public function addCard(string $provider, CardCreateRequest $request)
    {
        $service = $this->paymentFactory->make($provider);

        $result = $service->addCard(
            $request->user()->id,
            $request->card_number,
            $request->expire
        );

        return $this->sendResponse($result);
        // Response: { card_id, token, phone, wait }
    }

    // QADAM 2: OTP tasdiqlash
    public function verifyCard(string $provider, CardVerifyRequest $request)
    {
        $service = $this->paymentFactory->make($provider);

        $card = $service->verifyCard(
            $request->card_id,
            $request->token,
            $request->code
        );

        return $this->sendResponse([
            'message'     => 'Karta tasdiqlandi!',
            'is_verified' => $card->is_verified,
        ]);
    }

    // QADAM 3+4+5: To'lov
    public function pay(string $provider, PaymentRequest $request)
    {
        $service = $this->paymentFactory->make($provider);

        $transaction = $service->initiatePayment(
            $request->order_id,
            $request->card_id,
            $request->user()->id
        );

        return $this->sendResponse([
            'transaction_id' => $transaction->id,
            'status'         => $transaction->status->label(),
            'amount'         => $transaction->amount / 100, // tiyindan so'mga
        ]);
    }

    // Bekor qilish
    public function cancel(string $provider, int $transactionId)
    {
        $service = $this->paymentFactory->make($provider);

        $transaction = $service->cancelPayment($transactionId);

        return $this->sendResponse([
            'status'  => $transaction->status->label(),
            'message' => 'To\'lov bekor qilindi',
        ]);
    }

    // Webhook (Payme, Click va h.k lar uchun)
    public function webhook(string $provider, Request $request)
    {
        
        $service = $this->paymentFactory->make($provider);

        return $service->handleWebhook($request);
    }
}
