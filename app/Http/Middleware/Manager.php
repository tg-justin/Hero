<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Manager
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasRole('manager')) { // Check if the user is a manager
            abort(403, 'Unauthorized'); // Return a 403 error if not authorized
        }

        return $next($request);
    }
}
