<?php

namespace App\Services\Common\Payment;

use App\Services\Common\Payment\Contracts\PaymentProviderInterface;
use App\Services\Common\Payment\Providers\ClickProvider;
use App\Services\Common\Payment\Providers\PaymeProvider;
use App\Services\Common\Payment\Providers\PaynetProvider;
use Illuminate\Support\Facades\App;

class PaymentFactory
{
    /**
     * @param string $provider (masalan: 'payme', 'click', 'paynet')
     * @return PaymentProviderInterface
     * @throws \Exception
     */
    public function make(string $provider): PaymentProviderInterface
    {
        return match (strtolower($provider)) {
            'payme'  => App::make(PaymeProvider::class),
            'click'  => App::make(ClickProvider::class),
            'paynet' => App::make(PaynetProvider::class),
            default  => throw new \Exception("Noma'lum to'lov tizimi: {$provider}"),
        };
    }
}
