<?php

namespace Cancionistica\Services\PaymentStrategy;

use Cancionistica\Services\PaymentStrategy\Mercadopago\MercadopagoPaymentStrategy;
use Cancionistica\ValueObjects\PaymentMethod;
use Exception;

abstract class PaymentStrategy
{
    public abstract function pay();
    public abstract function validateData();

    /**
     * @param PaymentMethod $method
     * @return static
     * @throws Exception
     */
    public static function make(PaymentMethod $method): self {
        return match ($method) {
            PaymentMethod::MERCADOPAGO => app(MercadopagoPaymentStrategy::class),
            default => throw new Exception("Payment method not supported"),
        };
    }
}
