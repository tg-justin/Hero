<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
	/**
	 * Mark the authenticated user's email address as verified.
	 */
	public function __invoke(EmailVerificationRequest $request): RedirectResponse
	{
		$user = $request->user();

		if ($user->hasVerifiedEmail())
		{
			return redirect()->intended(route('quests.index', absolute: FALSE) . '?verified=1');
		}

		if ($user->markEmailAsVerified())
		{
			event(new Verified($user));
		}

		// Update the last_login_at field
		$user->last_login_at = Carbon::now();
		$user->save();

		return redirect()->intended(route('quests.index', absolute: FALSE) . '?verified=1');
	}
}