<?php

namespace Cancionistica\Apis;

use Cancionistica\DataContracts\ProductData;
use Exception;
use MercadoPago\Preference;

interface PaymentApi
{
    /**
     * @param string $method
     * @param ProductData $data
     * @throws Exception
     */
    public function initializePayment(string $method, ProductData $data);
}
