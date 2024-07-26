<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
		if (!Auth::check()) { //check if the user is authenticated
			return redirect()->route('sign-in'); // If not authenticated, redirect to the sigin page
		}

		return $request->user()->hasVerifiedEmail()
			? redirect()->intended(route('sign-in', absolute: FALSE))
			: view('auth.verify-email');
	}
}