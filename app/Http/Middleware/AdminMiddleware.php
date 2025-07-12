<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
            abort(403, 'Solo los administradores pueden acceder.');
        }
        return $next($request);
    }
}
