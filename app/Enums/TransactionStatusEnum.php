<?php

namespace App\Enums;

enum TransactionStatusEnum: int
{
    case PENDING    = 0;
    case PROCESSING = 1;
    case PAID       = 2;
    case CANCELLED  = 3;
    case FAILED     = 4;

    public function label(): string
    {
        return match($this) {
            self::PENDING    => 'Kutilmoqda',
            self::PROCESSING => 'Jarayonda',
            self::PAID       => 'To\'landi',
            self::CANCELLED  => 'Bekor qilindi',
            self::FAILED     => 'Xatolik',
        };
    }
}
