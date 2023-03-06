<?php

namespace App\Http\Middleware;

use Closure;

class RequestTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->bearerToken() || $request->bearerToken() !== config('auth.app_token')) {
            return response()->json([
                'status' => false,
                'success' => false,
                'error' => 'Token não enviado ou inválido!'
            ], 401, ['X-Header-One' => 'Header Value']);
        }
        return $next($request);
    }
}
