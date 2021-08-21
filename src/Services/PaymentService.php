<?php

namespace Cancionistica\Services;

use Cancionistica\Apis\PaymentApi;
use Cancionistica\DataContracts\ProductData;
use Cancionistica\Services\PaymentStrategy\PaymentStrategy;
use Cancionistica\ValueObjects\PaymentMethod;

class PaymentService implements PaymentApi
{
    /**
     * {@inheritDoc}
     */
    public function initializePayment(string $method, ProductData $data)
    {
        $strategy = PaymentStrategy::make(PaymentMethod::make($method));
        $strategy->pay($data);
    }
}
