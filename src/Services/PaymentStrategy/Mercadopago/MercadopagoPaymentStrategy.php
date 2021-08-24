<?php

namespace Cancionistica\Services\PaymentStrategy\Mercadopago;

use Cancionistica\DataContracts\ProductData;
use Cancionistica\Services\PaymentStrategy\PaymentStrategy;
use Exception;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadopagoPaymentStrategy extends PaymentStrategy
{
    /**
     * @param ProductData $data
     * @return string
     * @throws Exception
     */
    public function pay(ProductData $data)
    {
        $this->initializeSDK();
        $preference = $this->createPreference($data);
        $preference->save();
        return $preference->id;
    }

    /**
     * @param ProductData $data
     * @return Preference
     */
    private function createPreference(ProductData $data): Preference
    {
        $preference = new Preference();
        $preference->items = [$this->getItem($data)];
        $preference->payer = $this->getPayer();
        $callbackUrl = config("app.frontend_url");
        $preference->back_urls = [
            "success" => $callbackUrl,
            "failure" => $callbackUrl,
            "pending" => $callbackUrl
        ];
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

    /**
     * @param ProductData $data
     * @return Item
     */
    private function getItem(ProductData $data): Item
    {
        $item = new Item();
        $item->title = $data->getProductName();
        $item->id = $data->getProductId();
        $item->quantity = $data->getProductQuantity();
        $item->unit_price = $data->getProductPrice();
        $item->currency_id = "ARS";
        return $item;
    }

    /**
     * @return Payer
     */
    private function getPayer(): Payer
    {
        $payer = new Payer();
        $payer->id = auth()->user()->id;
        $payer->name = auth()->user()->name;
        $payer->email = auth()->user()->email;
        return $payer;
    }

}
