<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->role !== 'administrador') {
            if (Auth::user()->role === 'cajero') {
                return redirect()->route('pos.index');
            }
            abort(403, 'ACCESO DENEGADO: Solo administradores.');
        }

        return $next($request);
    }
}