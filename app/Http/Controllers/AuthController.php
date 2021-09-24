<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Cancionistica\Apis\EncryptionApi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(private EncryptionApi $encryptionApi)
    {
    }

    /**
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = new User($request->only('name', 'email'));
            $hashed = bcrypt($request->get('password'));
            $user->password = $hashed;
            $user->save();
            $user->sendEmailVerificationNotification();
            return response()->json($user->load("personalInfo"));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only("email", "password");

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json(User::with("personalInfo")->find(auth()->id()));
            }

            return response()->json([
                'email' => 'The provided credentials do not match our records.',
            ], 403);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->json(['message' => 'Logged out.']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function loggedUser(): JsonResponse
    {
        try {
            return auth()->user()
                ? response()->json(User::with(["personalInfo"])->find(auth()->id()))
                : response()->json(["error" => "unauthenticated"], 401);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function emailExists(string $email): JsonResponse
    {
        try {
            $user = User::where("email", $email)->first();
            $status = $user ? 200 : 404;
            return response()->json(!!$user, $status);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function isAdmin(): Response
    {
        return (config("app.admin.email") === auth()->user()?->email)
            ? response(null, 200)
            : response(null, 403);
    }

    /**
     * @return Response|Application|ResponseFactory
     * @throws Exception
     */
    public function emails(): Response|Application|ResponseFactory
    {
        $emails = DB::table("users")->select("email")->get()->map(function ($emailObj) {
            return $emailObj->email;
        });
        $passphrase = config("app.encryption_passphrase");
        $encrypted = $this->encryptionApi->encrypt($passphrase, $emails);
        return response($encrypted);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function password(): string
    {
        $passphrase = config("app.encryption_passphrase");
        return $this->encryptionApi->encrypt($passphrase, auth()->user()?->getAuthPassword());
    }
}
