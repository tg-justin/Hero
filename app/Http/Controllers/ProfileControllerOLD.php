<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Carbon\CarbonTimeZone;
use Mews\Purifier\Purifier;

class ProfileControllerOLD extends Controller
{

	/**
	 * Show the form for editing the user's public information.
	 */
	public function editPublicInfoOLD(): View
	{
		$hero = Auth::user();
		$viewer = $hero;
		$hasPermission = TRUE;
		return view('profile.update-public-info', compact('hero', 'viewer', 'hasPermission'));
	}

	/**
	 * Update the user's public information.
	 */
	public function updatePublicInfo(Request $request): RedirectResponse
	{
		$request->user()->fill($request->all());

		if ($request->user()->isDirty('email'))
		{
			$request->user()->email_verified_at = NULL;
		}

		$request->user()->save();

		return Redirect::route('profile.edit')->with('status', 'profile-updated');
	}

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

	public function updateHeroRegistration(Request $request): RedirectResponse
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