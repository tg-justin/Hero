<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HeroController extends Controller
{
	public function index(Request $request)
	{
		$query = User::whereHas('roles', function($query)
		{
			$query->where('name', 'hero');
		});

		if ($request->has('search'))
		{
			$search = $request->input('search');
			$query->where('name', 'like', "%$search%");
		}

		$heroes = $query->get();

		return view('manager.heroes', compact('heroes'));
	}

	public function promote(User $hero)
	{
		/*$this->authorize('promote', $hero); // Check if the user is authorized to promote*/

		$hero->assignRole('manager'); // Assign the 'manager' role

		return back()->with('success', 'Hero promoted to manager successfully!');
	}

	public function sendPasswordResetEmail(User $hero)
	{
		$this->authorize('sendPasswordResetEmail', $hero);
		Password::sendResetLink(['email' => $hero->email]);

		return back()->with('success', 'Password reset email sent successfully.');
	}

// Helper method to get status color (you can move this to a Trait or Helper class if you prefer)
	protected function getStatusColor($status)
	{
		return match ($status)
		{
			'in_progress' => 'bg-blue-200',
			'completed' => 'bg-green-200',
			'failed' => 'bg-red-200',
			'expired' => 'bg-yellow-200',
			'accepted' => 'bg-seance-200',  // Assuming 'seance' is defined in your config
			default => 'bg-gray-200',
		};
	}
}
