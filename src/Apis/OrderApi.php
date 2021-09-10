<?php

namespace Cancionistica\Apis;

use Illuminate\Support\Collection;

interface OrderApi
{
    public function createOrder(array $items, string $preferenceId): void;
    public function getOrders(): Collection;
}
