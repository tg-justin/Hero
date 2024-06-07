<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) { // Check if the user is a manager
            abort(403, 'Unauthorized'); // Return a 403 error if not authorized
        }

        return $next($request);
    }
}
