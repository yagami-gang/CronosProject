<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->hasRole('gestionnaire'))) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Accès non autorisé. Privilèges manager requis.');
    }
}