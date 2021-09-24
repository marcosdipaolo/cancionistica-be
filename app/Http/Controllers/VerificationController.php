<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->only("resend");
    }

    public function verify(string $id, string $hash, Request $request): RedirectResponse {
        try {
            $user = User::findOrFail($id);
            if(
                (!hash_equals($user->getKey(), $id))
                || (!hash_equals(sha1($user->getEmailForVerification()), $hash))
                || !$request->hasValidSignature()) {
                return redirect()->to(config("app.frontend_url") . "?verifying_status=error");
            }
            if ($user->hasVerifiedEmail()) {
                return redirect()->to(config("app.frontend_url") . "?verifying_status=already");
            }
            $user->markEmailAsVerified();
            return redirect()->to(config("app.frontend_url") . "?verifying_status=success");
        } catch(\Throwable $e) {
            logger()->error($e->getMessage(), $e->getTrace());
            return redirect()->to(config("app.frontend_url") . "?verifying_status=error");
        }
    }

    public function resend(): JsonResponse {
        /**
         * because if not logged we wouldn't be here wouldn't we...?
         * @var User $user
         */
        $user = auth()->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
