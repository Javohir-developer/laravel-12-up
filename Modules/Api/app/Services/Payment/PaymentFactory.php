<?php

namespace Modules\Api\Services\Payment;

use Modules\Api\Services\Payment\Contracts\PaymentProviderInterface;
use Modules\Api\Services\Payment\Providers\ClickProvider;
use Modules\Api\Services\Payment\Providers\PaymeProvider;
use Modules\Api\Services\Payment\Providers\PaynetProvider;
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
