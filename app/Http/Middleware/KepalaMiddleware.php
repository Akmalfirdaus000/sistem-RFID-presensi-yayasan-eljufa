<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KepalaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'kepala') {
            return $next($request);
        }

        return redirect()->route('user.dashboard')->with('error', 'Akses ditolak: hanya untuk kepala.');
    }
}
