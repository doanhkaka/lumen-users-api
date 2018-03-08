<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogMiddleware
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
        Log::info('ApiRequest', [
            'url'       => $request->getRequestUri(),
            'method'    => $request->getMethod(),
            'ip'        => $request->getClientIp(),
            'headers'   => $request->headers->all(),
            'request'   => $request->all(),
        ]);

        return $next($request);
    }
}