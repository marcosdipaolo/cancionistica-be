<?php

namespace Cancionistica\Services\PaymentStrategy\Mercadopago;

use Cancionistica\Apis\OrderApi;
use Cancionistica\DataContracts\ProductData;
use Cancionistica\Services\PaymentStrategy\PaymentStrategy;
use Exception;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadopagoPaymentStrategy extends PaymentStrategy
{
    public function __construct(private OrderApi $orderApi)
    {

    }
    /**
     * @param ProductData $data
     * @return string
     * @throws Exception
     */
    public function pay(ProductData $data): string
    {
        $this->initializeSDK();
        $preference = $this->createPreference($data);
        $preference->save();
        $this->orderApi->createOrder($data->getItems(), $preference->id);
        return $preference->id;
    }

    /**
     * @param ProductData $data
     * @return Preference
     */
    private function createPreference(ProductData $data): Preference
    {
        $preference = new Preference();
        $preference->items = $this->getItems($data);
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
     * @return Item[]
     */
    private function getItems(ProductData $data): array
    {
        $items = [];
        foreach($data->getItems() as $product) {
            $item = new Item();
            $item->title = $product["title"];
            $item->id = $product["id"];
            $item->quantity = $product["quantity"];
            $item->unit_price = $product["price"];
            $item->currency_id = "ARS";
            array_push($items, $item);
        }
        return $items;
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
