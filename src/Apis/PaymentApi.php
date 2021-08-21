<?php

namespace Cancionistica\Apis;

use Cancionistica\DataContracts\ProductData;
use Exception;

interface PaymentApi
{
    /**
     * @param string $method
     * @param ProductData $data
     * @return void
     * @throws Exception
     */
    public function initializePayment(string $method, ProductData $data);
}
