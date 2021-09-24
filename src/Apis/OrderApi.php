<?php

namespace Cancionistica\Apis;

use Illuminate\Support\Collection;

interface OrderApi
{
    /**
     * @param array $items
     * @param string $preferenceId
     */
    public function createOrder(array $items, string $preferenceId): void;

    /**
     * @return Collection
     */
    public function getOrders(): Collection;

    /**
     * @return Collection
     */
    public function getAllOrders(): Collection;
}
