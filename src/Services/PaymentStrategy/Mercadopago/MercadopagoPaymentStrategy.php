<?php

namespace Cancionistica\Services\PaymentStrategy\Mercadopago;

use Cancionistica\DataContracts\ProductData;
use Cancionistica\Services\PaymentStrategy\PaymentStrategy;
use Exception;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadopagoPaymentStrategy extends PaymentStrategy
{
    /**
     * @param ProductData $data
     * @return bool
     * @throws Exception
     */
    public function pay(ProductData $data): bool
    {
        $this->initializeSDK();
        $preference = $this->createPreference($data);
        return $preference->save();
    }

    /**
     * @param ProductData $data
     * @return Preference
     */
    private function createPreference(ProductData $data): Preference
    {
        $preference = new Preference();
        $item = new Item();
        $item->productName = $data->getProductName();
        $item->productId = $data->getProductId();
        $item->productQuantity = $data->getProductQuantity();
        $item->productPrice = $data->getProductPrice();
        $preference->items = [$item];
        return $preference;
    }

    private function initializeSDK()
    {
        SDK::setAccessToken($this->getAccessToken());
    }

    private function getAccessToken()
    {
        return config("mercadopago.accessToken");
    }

}
