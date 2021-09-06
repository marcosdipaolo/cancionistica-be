<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        try {
            $request->validate(["email" => "required|email"]);
            $status = Password::sendResetLink(
                $request->only('email')
            );
            return $status === Password::RESET_LINK_SENT
                ? response()->json(["message" => $status])
                : response()->json(["error" => $status], 422);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function reset(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]);
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
                    $user->save();
                    event(new PasswordReset($user));
                }
            );
            return $status === Password::PASSWORD_RESET
                ? response()->json(["message" => $status])
                : response()->json(["error" => $status], 422);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function change(Request $request): JsonResponse
    {
        try {
            $request->validate([
                "old_password" => "required|string",
                "new_password" => "required|string|confirmed",
            ]);
            [
                "old_password" => $old_password,
                "new_password" => $new_password,
                "new_password_confirmation" => $new_password_confirmation,
            ] = $request->all();
            if (!Hash::check($old_password, auth()->user()->password)) {
                return response()->json([
                    "errors" => [
                        "old_opassword" => "Wrong current password"
                    ]
                ], 401);
            }
            if (Hash::check($new_password, auth()->user()->password)) {
                return response()->json([
                    "errors" => [
                        "old_opassword" => "New password must be different that the old one."
                    ]
                ], 409);
            }
            if ($new_password !== $new_password_confirmation) {
                return response()->json([
                    "errors" => [
                        "new_password_confirmation" => "New password and its confirmation must match."
                    ]
                ], 422);
            }
            $user = User::find(auth()->id());
            $user->password = Hash::make($new_password);
            $user->save();
            return response()->json(["message" => "Password changed"]);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function passwordMatches(Request $request): JsonResponse
    {
        $request->validate([
            "password" => "string|required"
        ]);
        return (auth()->user() && Hash::check($request->get('password'), auth()->user()->password))
            ? response()->json(["matches" => true])
            : response()->json(["matches" => false]);
    }
}
