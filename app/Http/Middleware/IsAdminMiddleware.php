<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->type !== "ADMIN") {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
