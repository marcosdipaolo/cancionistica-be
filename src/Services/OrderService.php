<?php

namespace Cancionistica\Services;

use App\Models\Order;
use Cancionistica\Apis\OrderApi;
use Illuminate\Support\Collection;

class OrderService implements OrderApi
{

    public function createOrder(array $items, string $preferenceId): void
    {
        $order = Order::create([
            "preference_id" => $preferenceId,
            "user_id" => auth()->id()
        ]);
        $order->courses()->sync(array_reduce($items, function (array $carry, array $item) {
            $carry[$item["id"]] = ["quantity" => $item["quantity"]];
            return $carry;
        }, []));
    }

    public function getOrders(): Collection
    {
        return Order::with("courses")
            ->join("payments", "orders.preference_id", "=", "payments.preference_id")
            ->select("orders.*", "payments.status", "payments.payment_type")
            ->where("orders.user_id", "=", auth()->id())
            ->get();
    }
}
