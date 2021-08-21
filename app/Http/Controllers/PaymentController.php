<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use Cancionistica\Apis\PaymentApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function __construct(private PaymentApi $paymentApi)
    {
    }

    public function makePayment(PaymentRequest $request, string $method): Response | JsonResponse
    {
        try {
            $this->paymentApi->initializePayment($method, $request);
            return response()->noContent(200);
        } catch(\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
