<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->ajax() && !app()->runningUnitTests()) {
            return response()->json(['error' => 'Forbidden: API access is restricted to the application frontend.'], 403);
        }

        return $next($request);
    }
}
