<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->roles->doesntContain('name', $role)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}