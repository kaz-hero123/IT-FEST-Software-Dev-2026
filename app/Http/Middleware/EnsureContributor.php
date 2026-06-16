<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureContributor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || (Auth::user() && Auth::user()->role !== 'contributor')) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
