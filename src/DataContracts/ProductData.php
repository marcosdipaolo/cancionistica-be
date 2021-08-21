<?php

namespace Cancionistica\DataContracts;

interface ProductData
{
    public function getProductId(): string;
    public function getProductName(): string;
    public function getProductPrice(): string;
    public function getProductQuantity(): int;
}
