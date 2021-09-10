<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class Admin
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (auth()->user()?->email === config("app.admin.email")) {
            return $next($request);
        }
        return response()->json(["message" =>"Only for admin users"], 403);
    }
}
