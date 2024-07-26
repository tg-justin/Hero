<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UnauthenticatedVerifyEmail
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next): mixed
	{
		if (!Auth::check() && $request->route('id') && $request->route('hash'))
		{
			$user = User::findOrFail($request->route('id'));
			Auth::login($user);
		}
		return $next($request);
	}
}