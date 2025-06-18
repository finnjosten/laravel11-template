<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Maintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! env('SETTING_MAINTENANCE')) return $next($request);

        if (env('SETTING_MAINTENANCE_TOTAL')) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Maintenance mode is enabled',
                ], 503);
            }
            return response()->view('pages.maintenance');
        }

        if (str_contains($request->url(), vlx_get_account_url()) || str_contains($request->url(), vlx_get_auth_url()) || str_contains($request->url(), 'api/')) {
            return $next($request);
        }

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maintenance mode is enabled',
            ], 503);
        }
        return response()->view('pages.maintenance');
    }
}
