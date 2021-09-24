<?php

namespace Cancionistica\Services;

use App\Models\Order;
use Cancionistica\Apis\OrderApi;
use Illuminate\Support\Collection;

class OrderService implements OrderApi
{
    /**
     * @inheritDoc
     */
    public function createOrder(array $items, string $preferenceId): void
    {
        $order = Order::create([
            "preference_id" => $preferenceId,
            "user_id" => auth()->id(),
            "amount" => $this->getAmount($items)
        ]);
        $order->courses()->sync(array_reduce($items, function (array $carry, array $item) {
            $carry[$item["id"]] = ["quantity" => $item["quantity"]];
            return $carry;
        }, []));
    }

    /**
     * @inheritDoc
     */
    public function getOrders(): Collection
    {
        return Order::with("courses.images")
            ->join("payments", "orders.preference_id", "=", "payments.preference_id")
            ->select("orders.*", "payments.status", "payments.payment_type", "payments.created_at")
            ->where("orders.user_id", "=", auth()->id())->orderBy("orders.created_at", "desc")
            ->get();
    }
    /**
     * @inheritDoc
     */
    public function getAllOrders(): Collection
    {
        return Order::with("courses.images", "user")
            ->join("payments", "orders.preference_id", "=", "payments.preference_id")
            ->select("orders.*", "payments.status", "payments.payment_type", "payments.created_at")
            ->orderBy("orders.created_at", "desc")
            ->get();
    }

    /**
     * @param array $items
     * @return float
     */
    private function getAmount(array $items): float
    {
        return array_reduce($items, function(float $carry, array $item){
            $carry += $item["price"];
            return $carry;
        }, 0);
    }
}
