<?php

namespace App\Http\Controllers;

use App\Dto\ContactFormData;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function contactForm(ContactFormRequest $request): JsonResponse
    {
        $data = (new ContactFormData())
            ->setEmail($request->getEmail())
            ->setMesage($request->getMessage())
            ->setName($request->getName());
        try {
            Mail::to(config("mail.from.address"))->send(new ContactFormMessage($data));
            return response()->json(["msg" => "OK"], 200);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
