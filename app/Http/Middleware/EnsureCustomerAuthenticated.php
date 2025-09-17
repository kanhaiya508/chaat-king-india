<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCustomerAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('customer')->check()) {
            // store intended URL and redirect to customer login
            return redirect()->route('customer.login')->with('error', 'Please login as customer.');
        }
        return $next($request);
    }
}
