<?php

namespace App\Models;

use App\Enums\TransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'transaction_id',
        'receipt_id',
        'amount',
        'status',
        'payme_response',
        'create_time',
        'perform_time',
        'cancel_time',
        'reason',
    ];

    protected $casts = [
        'status'         => TransactionStatusEnum::class,
        'payme_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
