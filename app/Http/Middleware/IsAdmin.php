<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
    
        // Kalau bukan admin, tendang balik ke dashboard biasa
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses admin.');
    }
}
