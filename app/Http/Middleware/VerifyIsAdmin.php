<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and is_admin is true
        if (!auth()->check() || !auth()->user()->is_admin) {
            // If not, redirect to the home page or an error page
            //abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
