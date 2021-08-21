<?php

namespace Cancionistica\ValueObjects;

use Exception;

class PaymentMethod
{
    const MERCADOPAGO = "mercadopago";
    const OTHER = "other";

    private function __construct(private string $method)
    {
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public static function mercadopago(): self
    {
        return new static(self::MERCADOPAGO);
    }

    public static function other(): self
    {
        return new static(self::OTHER);
    }

    /**
     * @param string $method
     * @return static
     * @throws Exception
     */
    public static function make(string $method): self
    {
        if (!static::paymentIsSupported($method)) {
            throw new Exception("Payment method not supported");
        }
        return new static($method);
    }

    /**
     * @param string|null $method
     * @return bool|string
     * @throws Exception
     */
    public function is(string $method = null): bool|string
    {
        if($method) {
            if(static::paymentIsSupported($method)) {
                return $this->getMethod() === $method;
            }
            throw new Exception("Payment method not supported");
        }
        return $this->getMethod();
    }

    private static function paymentIsSupported(string $method): bool
    {
        return in_array($method, [
            self::MERCADOPAGO,
            self::OTHER
        ]);
    }
}
