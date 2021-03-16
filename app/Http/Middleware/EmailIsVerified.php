<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (is_null($request->user()->email_verified_at)) {
            return response()->json([
                'error' => true,
                'message' => 'Email verification required',
                'type' => 'MAIL_VERIFY',
            ], 401);
        }

        return $next($request);
    }
}
