<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->isAdmin()) return $next($request);
        if (API_RESPONSE) {
            return response()->json([ 'status' => 'error', 'message' => 'Unauthorized' ], 403);
        }
        return abort(403);
    }
}
