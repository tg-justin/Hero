<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
	/**
	 * Display the user's profile form.
	 */
	public function edit(Request $request): View
	{
		return view('profile.edit', [
			'user' => $request->user(),
		]);
	}

	/**
	 * Delete the user's account.
	 */
	public function destroy(Request $request): RedirectResponse
	{
		$request->validateWithBag('userDeletion', [
			'password' => ['required', 'current_password'],
		]);

		$user = $request->user();

		Auth::logout();

		$user->delete();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return Redirect::to('/');
	}

	public function heroRegistration(Request $request)
	{
		// Check if the user has already finished the hero registration

		if ($request->user()->questLogs()->where('status', 'Completed')->count() > 0)
		{
			return redirect()->route('quests.index')
				->with('success', 'You have already completed the hero registration!
                                You can update your profile information from your profile page.');
		}

		return view('profile.hero-registration', [
			'user' => $request->user(),
		]);
	}

	public function submitHeroRegistration(Request $request)
	{
		if (!$request->user())
		{
			return abort(404);
		}

		$request->user()->update($request->all());

		// Find the quest log entry for the first quest and mark it as completed
		$questLog = $request->user()->questLogs()->first();

		$questLog->status = 'Completed';
		$questLog->completed_at = now();
		$questLog->save();

		$request->user()->levelUp();

		return redirect()->route('quests.index')
			->with('success', 'Hero registration submitted successfully!');
	}

	/**
	 * Update the user's profile information.
	 */
	public function update(ProfileUpdateRequest $request): RedirectResponse
	{
		$request->user()->fill($request->validated());

		if ($request->user()->isDirty('email'))
		{
			$request->user()->email_verified_at = NULL;
		}

		$request->user()->save();

		return Redirect::route('profile.edit')->with('status', 'profile-updated');
	}

	public function updateHeroRegistration(Request $request)
	{
		if (!$request->user())
		{
			return abort(404);
		}

		$request->user()->update($request->all());

		return redirect()->route('profile.edit')
			->with('success', 'Profile information updated successfully!');
	}
}
