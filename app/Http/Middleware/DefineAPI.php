<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DefineAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if ($request->is('api/*')) {
            define('API_RESPONSE', true);
            // Force the app to always return errors in JSON
            $request->headers->set('Accept', 'application/json');
        } else {
            // Define the web version
            define('API_RESPONSE', false);
        }

        return $next($request);
    }
}
