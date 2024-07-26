<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
	/**
	 * Send a new email verification notification.
	 */
	public function store(Request $request): RedirectResponse
	{
		if ($request->user()->hasVerifiedEmail())
		{
			// return redirect()->intended(route('quests.index', absolute: FALSE));
			return redirect()->intended(route('email.verified'))->with('warning', "<strong>Your email has already been verified.</strong>");
		}

		$request->user()->sendEmailVerificationNotification();

		return back()->with('status', 'verification-link-sent');
	}
}