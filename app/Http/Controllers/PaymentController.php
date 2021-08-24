<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use Cancionistica\Apis\PaymentApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function __construct(private PaymentApi $paymentApi)
    {
    }

    public function makePayment(PaymentRequest $request, string $method): Response|JsonResponse
    {
        try {
            $data = $this->paymentApi->initializePayment($method, $request);
            return response()->json(compact("data"));
        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    public function mercadopagoCallback(Request $request) {
        logger()->info(json_encode($request->all()));
    }
}
