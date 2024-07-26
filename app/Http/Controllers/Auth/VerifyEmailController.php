<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class VerifyEmailController extends Controller
{
	/**
	 * Mark the authenticated user's email address as verified.
	 */
	public function __invoke(EmailVerificationRequest $request): RedirectResponse
	{
		// Here, the user should already be authenticated by the middleware
		if ($request->user()->hasVerifiedEmail())
		{
			return redirect()->route('email.verified')->with('warning', "<strong>Your email has already been verified.</strong>");
		}

		if ($request->user()->markEmailAsVerified())
		{
			event(new Verified($request->user()));
		}

		return redirect()->route('email.verified')->with('success', '<strong>Your email has been verified.</strong>');
	}
}