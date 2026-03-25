<?php

namespace App\Services\Common\Payment\Providers;

use App\Enums\TransactionStatusEnum;
use App\Models\Card;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\Common\Payment\Contracts\PaymentProviderInterface;
use App\Services\Common\Payment\PaymeService;
use Illuminate\Http\Request;

class PaymeProvider implements PaymentProviderInterface
{
    public function __construct(
        private PaymeService $payme
    ) {}

    // =============================================
    // Karta qo'shish
    // =============================================
    public function addCard(int $userId, string $cardNumber, string $expire): array
    {
        // 1. Payme ga karta yuborish
        $card = $this->payme->createCard($cardNumber, $expire);

        // 2. DB ga saqlash (tasdiqlanmagan holda)
        $savedCard = Card::create([
            'user_id'     => $userId,
            'token'       => $card['token'],
            'number'      => $card['number'],
            'expire'      => $card['expire'],
            'is_verified' => false,
        ]);

        // 3. OTP yuborish
        $verify = $this->payme->sendVerifyCode($card['token']);

        return [
            'card_id' => $savedCard->id,
            'token'   => $card['token'],
            'phone'   => $verify['phone'] ?? null,   // qaysi raqamga yuborildi
            'wait'    => $verify['wait'] ?? null,     // kutish vaqti
        ];
    }

    // =============================================
    // Kartani OTP bilan tasdiqlash
    // =============================================
    public function verifyCard(int $cardId, string $token, string $code): Card
    {
        $card = Card::findOrFail($cardId);

        // Payme da tasdiqlash
        $verified = $this->payme->verifyCard($token, $code);

        // DB da yangilash
        $card->update([
            'token'       => $verified['token'],
            'is_verified' => true,
        ]);

        return $card;
    }

    // =============================================
    // To'lovni boshlash
    // =============================================
    public function initiatePayment(int $orderId, int $cardId, int $userId): Transaction
    {
        $order = Order::findOrFail($orderId);
        $card  = Card::findOrFail($cardId);

        // Karta tasdiqlanganmi?
        if (!$card->is_verified) {
            throw new \Exception('Karta tasdiqlanmagan!');
        }

        // Transaction yaratish
        $transaction = Transaction::create([
            'order_id' => $orderId,
            'user_id'  => $userId,
            'amount'   => $order->total_amount * 100, // so'mdan tiyinga
            'status'   => TransactionStatusEnum::PENDING,
        ]);

        try {
            // 1. Chek yaratish
            $receipt = $this->payme->createReceipt(
                $transaction->amount,
                (string)$orderId,
                "Order #{$orderId} uchun to'lov"
            );

            $transaction->update([
                'receipt_id' => $receipt['_id'],
                'status'     => TransactionStatusEnum::PROCESSING,
                'payme_response' => $receipt,
            ]);

            // 2. To'lovni amalga oshirish
            $result = $this->payme->payReceipt(
                $receipt['_id'],
                $card->token
            );

            // 3. Natijani saqlash
            if (isset($result['state']) && $result['state'] === 4) {
                $transaction->update([
                    'status'         => TransactionStatusEnum::PAID,
                    'payme_response' => $result,
                ]);

                // Order ni yangilash
                $order->update(['status' => 'paid']);
            }
        } catch (\Exception $e) {
            $transaction->update([
                'status' => TransactionStatusEnum::FAILED,
                'payme_response' => ['error' => $e->getMessage()],
            ]);

            throw $e;
        }

        return $transaction;
    }

    // =============================================
    // To'lovni bekor qilish
    // =============================================
    public function cancelPayment(int $transactionId): Transaction
    {
        $transaction = Transaction::findOrFail($transactionId);

        if (!$transaction->receipt_id) {
            throw new \Exception('Chek topilmadi!');
        }

        $result = $this->payme->cancelReceipt($transaction->receipt_id);

        $transaction->update([
            'status' => TransactionStatusEnum::CANCELLED,
            'payme_response' => $result,
        ]);

        return $transaction;
    }

    // =============================================
    // Webhook (Payme so'rovlarini qayta ishlash)
    // =============================================
    public function handleWebhook(Request $request): \Illuminate\Http\JsonResponse
    {
        // 1. Autentifikatsiya tekshirish
        if (!$this->authenticate($request)) {
            return response()->json([
                "jsonrpc" => "2.0",
                'id'      => $request->input('id'),
                'error' => [
                    'code'    => -32504,
                    'message' => 'Insufficient privilege to perform this method',
                ]
            ], 200);
        }

        $method = $request->input('method');
        $params = $request->input('params', []);

        return match ($method) {
            'CheckPerformTransaction' => $this->checkPerformTransaction($params),
            'CreateTransaction'       => $this->createTransaction($params),
            'PerformTransaction'      => $this->performTransaction($params),
            'CancelTransaction'       => $this->cancelTransaction($params),
            'CheckTransaction'        => $this->checkTransaction($params),
            'GetStatement'            => $this->getStatement($params),
            default                   => $this->methodNotFound(),
        };
    }

    // --- Webhook ichki metodlari ---

    private function checkPerformTransaction(array $params): \Illuminate\Http\JsonResponse
    {
        $orderId = $params['account']['order_id'] ?? null;
        $amount  = $params['amount'] ?? 0;

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                "jsonrpc" => "2.0",
                'id'      => request()->input('id'),
                'error'   => [
                    'code'    => -31050,
                    'message' => ['ru' => 'Заказ не найден', 'en' => 'Order not found', 'uz' => 'Buyurtma topilmadi'],
                    'data'    => 'order_id',
                ]
            ], 200);
        }

        if ($order->total_amount !== (int)$amount / 100) {
            return response()->json([
                "jsonrpc" => "2.0",
                'id'      => request()->input('id'),
                'error'   => [
                    'code'    => -31001,
                    'message' => ['ru' => 'Неверная сумма', 'uz' => 'Summa xato'],
                    'data'    => 'amount',
                ]
            ], 200);
        }

        return response()->json([
            "jsonrpc" => "2.0",
            'id'      => request()->input('id'),
            'result'  => [
                'allow' => true,
                "order_id" => (string)$orderId,
                "description" => "Buyurtma #{$orderId} uchun to'lov"
            ]
        ], 200);
    }

    private function createTransaction(array $params): \Illuminate\Http\JsonResponse
    {
        $transactionId = $params['id'];
        $orderId       = $params['account']['order_id'];
        $amount        = $params['amount'];
        $time          = $params['time'];

        $transaction = Transaction::where('transaction_id', $transactionId)->first();

        if (!$transaction) {
            $activeTransaction = Transaction::where('order_id', $orderId)
                ->where('status', TransactionStatusEnum::PROCESSING)
                ->first();

            if ($activeTransaction) {
                return response()->json([
                    "jsonrpc" => "2.0",
                    'id'      => request()->input('id'),
                    'error' => [
                        'code'    => -31050,
                        'message' => ['ru' => 'Заказ недоступен для оплаты', 'en' => 'Order is not available for payment', 'uz' => 'Buyurtma to\'lov uchun mavjud emas'],
                    ]
                ], 200);
            }
            $transaction = Transaction::create([
                'transaction_id' => $transactionId,
                'order_id'       => $orderId,
                'user_id'        => Order::find($orderId)?->user_id ?? 1,
                'amount'         => $amount,
                'status'         => TransactionStatusEnum::PROCESSING,
            ]);
        }

        return response()->json([
            "jsonrpc" => "2.0",
            'id'      => request()->input('id'),
            'result' => [
                'create_time'   => $time,
                'transaction'   => (string)$transaction->id,
                'state'         => 1,
                'receivers'     => null,
            ]
        ], 200);
    }

    private function performTransaction(array $params): \Illuminate\Http\JsonResponse
    {
        $transactionId = $params['id'];

        $transaction = Transaction::where('transaction_id', $transactionId)->first();

        if (!$transaction) {
            return response()->json([
                "jsonrpc" => "2.0",
                'id'      => request()->input('id'),
                'error' => [
                    'code'    => -31003,
                    'message' => ['ru' => 'Транзакция не найдена'],
                ]
            ], 200);
        }

        $transaction->update([
            'status' => TransactionStatusEnum::PAID,
        ]);

        if ($transaction->order) {
            $transaction->order->update(['status' => TransactionStatusEnum::PAID]);
        }

        return response()->json([
            "jsonrpc" => "2.0",
            'id'      => request()->input('id'),
            'result'  => [
                'transaction'  => (string)$transaction->id,
                'perform_time' => now()->timestamp * 1000,
                'state'        => 2,
            ]
        ], 200);
    }

    private function cancelTransaction(array $params): \Illuminate\Http\JsonResponse
    {
        $transactionId = $params['id'];
        $reason        = $params['reason'];

        $transaction = Transaction::where('transaction_id', $transactionId)->first();

        if ($transaction) {
            $transaction->update([
                'status' => TransactionStatusEnum::CANCELLED,
            ]);
        }

        return response()->json([
            "jsonrpc" => "2.0",
            'id'      => request()->input('id'),
            'result'  => [
                'transaction' => (string)$transaction?->id,
                'cancel_time' => now()->timestamp * 1000,
                'state'       => -1,
            ]
        ], 200);
    }

    private function checkTransaction(array $params): \Illuminate\Http\JsonResponse
    {
        $transaction = Transaction::where('transaction_id', $params['id'])->first();

        if (!$transaction) {
            return response()->json([
                "jsonrpc" => "2.0",
                'id'      => request()->input('id'),
                'error' => [
                    'code'    => -31003,
                    'message' => ['ru' => 'Транзакция не найдена'],
                ]
            ], 200);
        }

        return response()->json([
            "jsonrpc" => "2.0",
            'id'      => request()->input('id'),
            'result' => [
                'create_time'  => $transaction->created_at->timestamp * 1000,
                'perform_time' => $transaction->status === TransactionStatusEnum::PAID
                    ? $transaction->updated_at->timestamp * 1000 : 0,
                'cancel_time'  => $transaction->status === TransactionStatusEnum::CANCELLED
                    ? $transaction->updated_at->timestamp * 1000 : 0,
                'transaction'  => (string)$transaction->id,
                'state'        => $this->getPaymeState($transaction->status),
                'reason'       => null,
            ]
        ], 200);
    }

    private function getStatement(array $params): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "jsonrpc" => "2.0",
            'id'      => request()->input('id'),
            'result'  => [
                'transactions' => []
            ]
        ], 200);
    }

    private function authenticate(Request $request): bool
    {
        $auth = base64_decode(
            str_replace('Basic ', '', $request->header('Authorization', ''))
        );

        $parts = explode(':', $auth, 2);
        if (count($parts) < 2) {
            return false;
        }

        [, $key] = $parts;

        return $key === config('payme.key');
    }

    private function getPaymeState(TransactionStatusEnum $status): int
    {
        return match ($status) {
            TransactionStatusEnum::PROCESSING => 1,
            TransactionStatusEnum::PAID       => 2,
            TransactionStatusEnum::CANCELLED  => -1,
            default                           => 0,
        };
    }

    private function methodNotFound(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "jsonrpc" => "2.0",
            'id'      => request()->input('id'),
            'error'   => [
                'code'    => -32601,
                'message' => 'Method not found',
            ]
        ], 200);
    }
}
