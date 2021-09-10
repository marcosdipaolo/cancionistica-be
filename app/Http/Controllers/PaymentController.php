<?php

namespace App\Http\Controllers;

use App\Http\Requests\MPCallbackRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Cancionistica\Apis\PaymentApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function __construct(private PaymentApi $paymentApi)
    {
        $this->middleware("auth:sanctum")->except(["mercadopagoCallback"]);
    }

    public function makePayment(PaymentRequest $request, string $method): Response|JsonResponse
    {
        try {
            $data = $this->paymentApi->initializePayment($method, $request);
            return response()->json(compact("data"));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage(), "trace" => $e->getTraceAsString()], 500);
        }
    }

    public function mercadopagoCallback(MPCallbackRequest $request)
    {
        Payment::create($request->only(
            [
                "collection_id",
                "collection_status",
                "payment_id",
                "status",
                "payment_type",
                "merchant_order_id",
                "preference_id",
                "site_id",
                "processing_mode"
            ]
        ));
    }
}
