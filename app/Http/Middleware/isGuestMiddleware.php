<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isGuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->type === "ADMIN") {
            return redirect()->route('admin:order.index');
        }

        return $next($request);
    }
}
