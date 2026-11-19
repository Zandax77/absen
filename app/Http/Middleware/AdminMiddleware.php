<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('role') !== 'admin') {
            return redirect('admin/login')->with('error', 'Silakan login sebagai Admin terlebih dahulu.');
        }
        return $next($request);
    }
}
