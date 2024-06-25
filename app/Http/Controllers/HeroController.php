<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroController extends Controller
{
	public function index(Request $request): View
	{
		$myTimeZone = $request->user()->timezone ?? 'UTC';

		$query = User::query();
		if ($request->has('search'))
		{
			$search = $request->input('search');
			$query->where(function($q) use ($search)
			{
				$q->where('name', 'like', "%$search%")
					->orWhere('email', 'like', "%$search%");
			});
		}

		$query->orderBy('id');

		$heroes = $query->get();

		return view('manager.heroes', compact('heroes', 'myTimeZone'));
	}

	public function promote(User $hero): RedirectResponse
	{
		/*$this->authorize('promote', $hero); // Check if the user is authorized to promote*/

		$hero->assignRole('manager'); // Assign the 'manager' role

		return back()->with('success', 'Hero promoted to manager successfully!');
	}

	public function sendPasswordResetEmail(User $hero): RedirectResponse
	{
		$this->authorize('sendPasswordResetEmail', $hero);
		Password::sendResetLink(['email' => $hero->email]);

		return back()->with('success', 'Password reset email sent successfully.');
	}

// Helper method to get status color (you can move this to a Trait or Helper class if you prefer)
	protected function getStatusColor($status): string
	{
		return match ($status)
		{
			'In Progress' => 'bg-blue-200',
			'Completed' => 'bg-green-200',
			'failed' => 'bg-red-200',
			'Expired' => 'bg-yellow-200',
			'Accepted' => 'bg-seance-200',  // Assuming 'seance' is defined in your config
			default => 'bg-gray-200',
		};
	}
}