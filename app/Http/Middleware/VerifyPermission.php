<?php

namespace App\Http\Middleware;

use ApiResponse;
use Auth;
use Closure;

class VerifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $user = Auth::user();

        if ($user && !$user->can($request->route()->getName())) {
            return ApiResponse::error(\Lang::get('response.permission.revoked'), [], 403);
        }

        return $next($request);
    }
}
