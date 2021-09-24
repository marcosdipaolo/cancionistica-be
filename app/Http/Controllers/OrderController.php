<?php

namespace App\Http\Controllers;

use Cancionistica\Apis\OrderApi;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderApi $orderApi)
    {
        $this->middleware("auth")->only("getOrders");
        $this->middleware(["admin"])->only("getAllOrders");
    }

    public function getOrders(): JsonResponse
    {
        try {
            return response()->json($this->orderApi->getOrders());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    public function getAllOrders(): JsonResponse
    {
        try {
            return response()->json($this->orderApi->getAllOrders());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
