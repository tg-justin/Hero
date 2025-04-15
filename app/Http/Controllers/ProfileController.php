<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Carbon\CarbonTimeZone;
use Mews\Purifier\Purifier;
use Spatie\Newsletter\Facades\Newsletter;

class ProfileController extends Controller
{
	/****************************************************
	 * HERO REGISTRATION
	 ****************************************************/

	/**
	 * Show the Hero Registration form
	 *
	 * @return View|RedirectResponse
	 */
	public function heroRegistration(): View|RedirectResponse
	{
		$hero = Auth::user();

		// Check if the user has already finished the hero registration
		if ($hero->questLogs()->where('status', 'Completed')->where('quest_id', 1)->count() > 0)
		{
			// return redirect()->route('quests.index')
			// 	->with('success', 'You have already completed the hero registration! You can update your profile information from your profile page.');
		}

		$timezones = CarbonTimeZone::listIdentifiers();
		return view('profile.hero-registration', [
			'hero' => $hero,
			'timezones' => $timezones,
		]);
	}

	/**
	 * Process the submission of the hero registration form
	 *
	 * @param Request $request
	 * @param Purifier $purifier
	 *
	 * @return RedirectResponse
	 */
	public function submitHeroRegistration(Request $request, Purifier $purifier): RedirectResponse
	{
		if (!$request->user())
		{
			return abort(404);
		}

		$hero = $request->user();

		$validateData = $request->validate([
			// Public Information
			'name' => ['required', 'string', 'min:3', 'max:50'],
			'location' => ['nullable', 'string', 'max:50'],
			'public_profile' => ['nullable', 'string'],

			// Personal Information
			'first_name' => ['required', 'string', 'max:100'],
			'last_name' => ['required', 'string', 'max:100'],
			'pronouns' => ['nullable', 'string', 'max:20'],
			'phone_number' => ['nullable', 'string', 'max:25'],
			'timezone' => ['required', 'string', 'max:255'],

			// Mailing Address
			'address' => ['nullable', 'string', 'max:255'],
			'city' => ['nullable', 'string', 'max:255'],
			'state' => ['nullable', 'string', 'max:255'],
			'zip_code' => ['nullable', 'string', 'max:15'],
			'country' => ['nullable', 'string', 'max:255'],
		]);

		// Purify the 'public_profile' field
		if (isset($validateData['public_profile']))
		{
			$validateData['public_profile'] = $purifier->clean($validateData['public_profile']);
		}
		$hero->update($validateData);

		// Purify the 'past_volunteer_experience' field before setting to QuestLog
		$pastVolunteerExperience = $purifier->clean($request->input('past_volunteer_experience'));
		$strippedPastVolunteerExperience = strip_tags($pastVolunteerExperience);
		$reviewQuest = (strlen($strippedPastVolunteerExperience) > 10) ? 1 : 0;

		$questLog = $hero->questLogs()->where('quest_id', 1)->first();
		$questLog->feedback = $pastVolunteerExperience;
		$questLog->status = 'Completed';
		$questLog->review = $reviewQuest;
		$questLog->completed_at = now();
		$questLog->save();

		if ($request->input('newsletter_opt_in')) {
			try {
				Newsletter::subscribe('otterholik@gmail.com', ['FNAME' => $hero->first_name , 'LNAME' => $hero->last_name, 'HERO' => $hero->name, 'ZIPCODE' => $hero->zip_code ], listName: 'subscribers');
			} catch (\Exception $e) {
				// Handle any errors from the Mailchimp API (e.g., log them)
				Log::error('Mailchimp subscription error: ' . $e->getMessage());
			}
		}

		$hero->levelUp();

		return redirect()->route('quest-log.index')
			->with('success', 'Hero registration submitted successfully!');
	}

	/****************************************************
	 * PROFILE VIEWS
	 ****************************************************/

	/**
	 * Shows the authenticated hero their own profile
	 * @return View
	 */
	public function showProfileOwn(): View
	{
		$hero = Auth::user();
		$viewer = $hero;
		$self = TRUE;
		$hasPermission = TRUE;
		$myTimeZone = $viewer->timezone ?? 'UTC';
		return view('profile.show-profile', compact('hero', 'viewer', 'hasPermission', 'self', 'myTimeZone'));
	}

	/**
	 * Shows the profile of the specified heroId
	 *
	 * @param int $heroId
	 *
	 * @return View
	 */
	public function showProfile($heroId): View
	{
		$hero = User::findOrFail($heroId);
		$viewer = Auth::user();
		$self = ($hero == $viewer);
		$hasPermission = ($self || $viewer->hasRole('manager') || $viewer->hasRole('admin'));
		$myTimeZone = $viewer->timezone ?? 'UTC';
		return view('profile.show-profile', compact('hero', 'viewer', 'hasPermission', 'self', 'myTimeZone'));
	}

	/****************************************************
	 * PROFILE UPDATE - PUBLIC INFORMATION
	 ****************************************************/

	/**
	 * Show the form for editing the user's own Public Information.
	 * @note This is a simple redirect to the 'editPublicOther' method using the authenticated user's ID
	 * @return RedirectResponse
	 *
	 */
	public function editPublicInfoOwn(): RedirectResponse
	{
		$hero = Auth::user();
		return redirect()->route('profile.edit-public-info', ['heroId' => $hero->id]);
	}

	/**
	 * Show the form for editing a hero's Public Information.
	 *
	 * @param int $heroId
	 *
	 * @return View
	 */
	public function editPublicInfo($heroId): View
	{
		$hero = User::findOrFail($heroId);
		$viewer = Auth::user();
		$self = ($hero == $viewer);
		$hasPermission = ($self || $viewer->hasRole('manager') || $viewer->hasRole('admin'));

		if (!$hasPermission)
		{
			return abort(403);
		}

		return view('profile.edit-public-info', compact('hero', 'viewer', 'hasPermission', 'self'));
	}

	/**
	 * Process the submission of the Public Information form.
	 * @note This method handles both being updated by Hero or a Manager/Admin.
	 *
	 * @param Request $request
	 * @param Purifier $purifier
	 *
	 * @return RedirectResponse
	 */
	public function submitPublicInfo(Request $request, Purifier $purifier): RedirectResponse
	{
		// Find the hero (user) by the provided hero_id in the request
		$hero = User::findOrFail($request->input('hero_id'));

		// Get the currently authenticated user
		$viewer = Auth::user();

		// Check if the authenticated user is the hero (themselves)
		$self = ($hero == $viewer);

		// Determine if the viewer has permission to update the hero's information
		$hasPermission = ($self || $viewer->hasRole('manager') || $viewer->hasRole('admin'));

		// If the viewer does not have permission, return a 403 Forbidden response
		if (!$hasPermission)
		{
			return abort(403);
		}

		// Validate the incoming request data
		$validateData = $request->validate([
			// Public Information
			'name' => ['required', 'string', 'min:3', 'max:50'],
			'location' => ['nullable', 'string', 'max:50'],
			'public_profile' => ['nullable', 'string'],
		]);

		// Purify the 'public_profile' field if it is set
		if (isset($validateData['public_profile']))
		{
			$validateData['public_profile'] = $purifier->clean($validateData['public_profile']);
		}

		// Update the hero's information with the validated (and purified) data
		$hero->update($validateData);

		// Redirect back to the profile page with a success message
		if ($self)
		{
			return redirect()->route('profile.show-profile-own')
				->with('success', 'Public Information updated.');
		}

		return redirect()->route('profile.show-profile', ['heroId' => $hero->id])
			->with('success', 'Public Information updated.');
	}

	/****************************************************
	 * PROFILE UPDATE - PERSONAL INFORMATION
	 ****************************************************/

	/**
	 * Show the form for editing the user's own Personal Information.
	 * @return View
	 */
	public function editPersonalInfoOwn(): Redirect
	{
		$hero = Auth::user();
		return redirect()->route('profile.edit-personal-info', ['heroId' => $hero->id]);
	}

	/**
	 * Show the form for editing a hero's Personal Information.
	 *
	 * @param int $heroId
	 *
	 * @return View
	 */
	public function editPersonalInfo($heroId): View
	{
		$hero = User::findOrFail($heroId);
		$viewer = Auth::user();
		$self = ($hero == $viewer);
		$hasPermission = ($self || $viewer->hasRole('manager') || $viewer->hasRole('admin'));

		if (!$hasPermission)
		{
			return abort(403);
		}

		$timezones = CarbonTimeZone::listIdentifiers();
		return view('profile.edit-personal-info', compact('hero', 'viewer', 'hasPermission', 'self', 'timezones'));
	}

	/**
	 * Process the submission of the Personal Information form.
	 *
	 * @param Request $request
	 * @param Purifier $purifier
	 *
	 * @return RedirectResponse
	 */
	public function submitPersonalInfo(Request $request, Purifier $purifier): RedirectResponse
	{
		$hero = User::findOrFail($request->input('hero_id'));
		$viewer = Auth::user();
		$self = ($hero == $viewer);
		$hasPermission = ($self || $viewer->hasRole('manager') || $viewer->hasRole('admin'));

		if (!$hasPermission)
		{
			return abort(403);
		}

		$validateData = $request->validate([
			// Personal Information
			'first_name' => ['required', 'string', 'max:100'],
			'last_name' => ['required', 'string', 'max:100'],
			'pronouns' => ['nullable', 'string', 'max:20'],
			'phone_number' => ['nullable', 'string', 'max:25'],
			'timezone' => ['required', 'string', 'max:255'],
		]);

		$hero->update($validateData);

		// Redirect back to the profile page with a success message
		if ($self)
		{
			return redirect()->route('profile.show-profile-own')
				->with('success', 'Public Information updated.');
		}

		return redirect()->route('profile.show-profile', ['heroId' => $hero->id])
			->with('success', 'Public Information updated.');
	}

	/****************************************************
	 * PROFILE UPDATE - MAILING ADDRESS
	 ****************************************************/

	/**
	 * Show the form for editing the user's own Mailing Address.
	 * @return View
	 */
	public function editMailingAddressOwn(): Redirect
	{
		$hero = Auth::user();
		return redirect()->route('profile.edit-mailing-address', ['heroId' => $hero->id]);
	}

	/**
	 * Show the form for editing a hero's Mailing Information.
	 *
	 * @param int $heroId
	 *
	 * @return View
	 */
	public function editMailingAddress($heroId): View
	{
		$hero = User::findOrFail($heroId);
		$viewer = Auth::user();
		$self = ($hero == $viewer);
		$hasPermission = ($self || $viewer->hasRole('manager') || $viewer->hasRole('admin'));

		if (!$hasPermission)
		{
			return abort(403);
		}

		return view('profile.edit-mailing-address', compact('hero', 'viewer', 'hasPermission', 'self'));
	}

	/**
	 * Process the submission of the Mailing Address form.
	 *
	 * @param Request $request
	 * @param Purifier $purifier
	 *
	 * @return RedirectResponse
	 */
	public function submitMailingAddress(Request $request, Purifier $purifier): RedirectResponse
	{
		$hero = User::findOrFail($request->input('hero_id'));
		$viewer = Auth::user();
		$self = ($hero == $viewer);
		$hasPermission = ($self || $viewer->hasRole('manager') || $viewer->hasRole('admin'));

		if (!$hasPermission)
		{
			return abort(403);
		}

		$validateData = $request->validate([
			// Mailing Address
			'address' => ['nullable', 'string', 'max:255'],
			'city' => ['nullable', 'string', 'max:255'],
			'state' => ['nullable', 'string', 'max:255'],
			'zip_code' => ['nullable', 'string', 'max:15'],
			'country' => ['nullable', 'string', 'max:255'],
		]);

		$hero->update($validateData);

		// Redirect back to the profile page with a success message
		if ($self)
		{
			return redirect()->route('profile.show-profile-own')
				->with('success', 'Mailing Address updated.');
		}

		return redirect()->route('profile.show-profile', ['heroId' => $hero->id])
			->with('success', 'Mailing Address updated.');
	}

	/****************************************************
	 * DELETE ACCOUNT
	 ****************************************************/

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

	/****************************************************
	 * UPDATE PASSWORD
	 ****************************************************/

	/**
	 * Show the form for changing a hero's Password.
	 * @return View|RedirectResponse
	 */
	public function changePassword(): View|RedirectResponse
	{
		if (session('status') === 'password-updated')
		{
			return redirect()->route('profile.show-profile-own')
				->with('success', 'Password updated.');
		}
		return view('profile.change-password');
	}

	/****************************************************
	 * CHANGE EMAIL ADDRESS
	 ****************************************************/

	/**
	 * Show the form for changing a hero's Email Address.
	 * @return View|RedirectResponse
	 */
	public function changeEmailAddress(): View|RedirectResponse
	{
		$hero = Auth::user();

		// if (session('status') === 'password-updated')
		// {
		// 	return redirect()->route('profile.show-profile-own')
		// 		->with('success', 'Password updated.');
		// }
		return view('profile.change-email-address', compact('hero'));
	}

	// TODO: Add the submitChangeEmailAddress method

	/**
	 * Process the submission of the Change Email Address form.
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse
	 */
	public function submitChangeEmailAddress(Request $request): RedirectResponse
	{
		// Validate the request data
		$validateData = $request->validate([
			'email' => ['required', 'string', 'email', 'max:255'],
		]);

		// Get the authenticated user
		$hero = $request->user();

		// Set the new email address
		$hero->email = $validateData['email'];

		// Check if the email attribute is dirty
		if ($hero->isDirty('email'))
		{
			// If dirty, mark email as unverified and update the user
			$hero->email_verified_at = NULL;
			$hero->save();

			// Send verification email
			$hero->sendEmailVerificationNotification();

			return redirect()->route('profile.show-profile-own')
				->with('success', 'Email Address updated. Verification email sent.');
		}

		// If the email was not changed
		return redirect()->route('profile.show-profile-own')
			->with('success', 'Email Address not changed.');
	}
}