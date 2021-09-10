<?php

namespace App\Http\Controllers;

use Cancionistica\Apis\OrderApi;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderApi $orderApi)
    {
        $this->middleware("auth")->only("getOrders");
    }

    public function getOrders(): JsonResponse
    {
        try {
            return response()->json($this->orderApi->getOrders());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
