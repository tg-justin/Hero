<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
	/**
	 * Display the email verification prompt.
	 */
	public function __invoke(Request $request): RedirectResponse|View
	{
		if (!Auth::check())
		{ //check if the user is authenticated
			return redirect()->route('login'); // If not authenticated, redirect to the login page
		}

		return $request->user()->hasVerifiedEmail()
			? redirect()->intended(route('dashboard', absolute: FALSE))
			: view('auth.verify-email');
	}
}
