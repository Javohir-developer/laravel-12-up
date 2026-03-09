<?php

namespace App\Services\Common\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymeService
{
    private string $url;
    private string $merchantId;
    private string $secretKey;
    private int    $requestId = 1;

    public function __construct()
    {
        $this->url        = config('payme.url', 'https://checkout.test.paycom.uz/api');
        $this->merchantId = config('payme.id');
        $this->secretKey  = config('payme.key');
    }

    // =============================================
    // QADAM 1: Karta yaratish — cards.create
    // =============================================
    public function createCard(string $cardNumber, string $expire, bool $save = true): array
    {
        $response = $this->request('cards.create', [
            'card' => [
                'number' => $cardNumber, 
                'expire' => $expire,      
            ],
            'save' => $save,
        ]);

        if (isset($response['error'])) {
            throw new \Exception($response['error']['message']['ru'] ?? 'Noma\'lum xato');
        }

        return $response['result']['card'];
    }

    // =============================================
    // QADAM 2: OTP yuborish — cards.get_verify_code
    // =============================================
    public function sendVerifyCode(string $token): array
    {
        $response = $this->request('cards.get_verify_code', [
            'token' => $token,
        ]);

        if (isset($response['error'])) {
            throw new \Exception($response['error']['message']['ru'] ?? 'Noma\'lum xato');
        }

        return $response['result'];
    }

    // =============================================
    // QADAM 3: OTP tasdiqlash — cards.verify
    // =============================================
    public function verifyCard(string $token, string $code): array
    {
        $response = $this->request('cards.verify', [
            'token' => $token,
            'code'  => $code,
        ]);

        if (isset($response['error'])) {
            throw new \Exception($response['error']['message']['ru'] ?? 'Noma\'lum xato');
        }

        return $response['result']['card'];
    }

    // =============================================
    // QADAM 4: Chek yaratish — receipts.create
    // =============================================
    public function createReceipt(int $amount, string $orderId, string $description = ''): array
    {
        $response = $this->request('receipts.create', [
            'amount'  => $amount,   // TIYIN!
            'account' => [
                'order_id' => $orderId,
            ],
            'detail' => [
                'description' => $description ?: "To'lov #{$orderId}",
            ],
        ]);

        if (isset($response['error'])) {
            throw new \Exception($response['error']['message']['ru'] ?? 'Noma\'lum xato');
        }

        return $response['result']['receipt'];
    }

    // =============================================
    // QADAM 5: To'lov — receipts.pay
    // =============================================
    public function payReceipt(string $receiptId, string $cardToken): array
    {
        $response = $this->request('receipts.pay', [
            'id'    => $receiptId,
            'token' => $cardToken,
        ]);

        if (isset($response['error'])) {
            throw new \Exception($response['error']['message']['ru'] ?? 'Noma\'lum xato');
        }

        return $response['result']['receipt'];
    }

    // =============================================
    // Chek holatini tekshirish — receipts.check
    // =============================================
    public function checkReceipt(string $receiptId): array
    {
        $response = $this->request('receipts.check', [
            'id' => $receiptId,
        ]);

        if (isset($response['error'])) {
            throw new \Exception($response['error']['message']['ru'] ?? 'Noma\'lum xato');
        }

        return $response['result']['receipt'];
    }

    // =============================================
    // Chekni bekor qilish — receipts.cancel
    // =============================================
    public function cancelReceipt(string $receiptId): array
    {
        $response = $this->request('receipts.cancel', [
            'id' => $receiptId,
        ]);

        if (isset($response['error'])) {
            throw new \Exception($response['error']['message']['ru'] ?? 'Noma\'lum xato');
        }

        return $response['result']['receipt'];
    }

    // =============================================
    // HTTP Request yuborish
    // =============================================
    private function request(string $method, array $params): array
    {
        $payload = [
            'id'     => $this->requestId++,
            'method' => $method,
            'params' => $params,
        ];

        Log::info("Payme request: $method", $payload);

        $response = Http::withHeaders([
            'X-Auth' => $this->merchantId . ':' . $this->secretKey,
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache',
        ])->post($this->url, $payload);

        $result = $response->json();

        Log::info("Payme response: $method", $result ?? []);

        return $result ?? [];
    }
}
