<?php

namespace App\Http\Controllers;

use App\Models\QuestLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;


class QuestLogController extends Controller
{
	/**
	 * Display the user's quest log.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request): View
	{
		$user = $request->user();

		// Eager load quest log entries with associated quest data
		$acceptedQuests = auth()->user()->questLogs()->where('status', 'Accepted')->with('quest')->get();
		$pendingReview = auth()->user()->questLogs()->where('status', 'Pending Review')->with('quest')->get();
		$completedQuests = auth()->user()->questLogs()->where('status', 'Completed')->with('quest')->get();

		// Add statusColor to each questLog
		$acceptedQuests = $acceptedQuests->map(function($questLog)
		{
			$questLog->statusColor = 'bg-seance-600';
			return $questLog;
		});

		$exceptionRequests = $pendingReview->map(function($questLog)
		{
			$questLog->statusColor = 'bg-blue-600';
			return $questLog;
		});

		$completedQuests = $completedQuests->map(function($questLog)
		{ // Changed $quest to $questLog
			$questLog->statusColor = 'bg-green-600';
			return $questLog;
		});

		return view('quest-logs.quest-log', compact('acceptedQuests', 'pendingReview', 'completedQuests', 'user'));
	}

	public function indexForUser(User $user, Request $request): View
	{
		$questLogsQuery = $user->questLogs()->with('quest.category'); // Initialize query

		// Sorting logic (same as before)
		$sortBy = $request->get('sort', 'status');
		$direction = $request->get('direction', 'asc');
		$questLogsQuery->orderByRaw("FIELD(status, 'requested_exception', 'Pending Review', 'Accepted', 'Completed', 'failed') $direction");

		// Pagination
		$questLogs = $questLogsQuery->paginate(15); // 15 items per page

		// Status Color Mapping (use collection method on paginated results)
		$questLogs->getCollection()->transform(function($questLog)
		{
			$questLog->statusColor = $this->getStatusColor($questLog->status);
			return $questLog;
		});

		return view('quest-logs.index', ['questLogs' => $questLogs, 'user' => $user]);
	}

	protected function getStatusColor($status): string
	{
		return match ($status)
		{
			'Pending Review' => 'bg-blue-600', // Added bg-
			'Completed' => 'bg-green-600',  // Added bg-
			'FAiled' => 'bg-red-600',      // Added bg-
			'Requested Exception' => 'bg-yellow-600',  // Added bg- (if applicable)
			'Accepted' => 'bg-seance-600',  // Assuming 'seance' is defined in your config
			default => 'bg-gray-600',      // Added bg-
		};
	}

	public function edit(QuestLog $questLog) :View
	{
		// Authorize the user (e.g., using a middleware or policy)
		return view('quest-logs.edit', compact('questLog'));
	}

	public function showCompleteForm(QuestLog $questLog): View
	{
		// Authorization check: Ensure the user owns this quest log
		if (auth()->user()->id !== $questLog->user_id)
		{
			abort(403, 'Unauthorized');
		}

		return view('quest-logs.complete', compact('questLog'));
	}

	public function complete(QuestLog $questLog, Request $request): RedirectResponse
	{
		// Authorize the user (make sure only the hero who owns the quest log can complete it)
		if (auth()->user()->id !== $questLog->user_id)
		{
			abort(403, 'Unauthorized');
		}

		$validatedData = $request->validate([
			'completion_details' => 'nullable|string', // Validate the completion details (can be empty)
		]);

		$questLog->update([
			'status' => 'Completed',
			'completed_at' => now(),
			'completion_details' => $validatedData['completion_details'],
		]);

		// Log this happened
		activity()
			->causedBy(auth()->user())
			->performedOn($questLog)
			->log('Quest completed');

		$questLog->user->levelUp();

		return redirect()->route('quest-log.index')->with('success', 'Quest completed!');
	}

	public function update(Request $request, QuestLog $questLog): RedirectResponse
	{
		// Authorize the user (e.g., using a middleware or policy)

		$request->validate([
			'status' => 'required|in:Accepted,Requested Exception,In Progress,Completed,Pending Review,Failed', // Add other validation rules as needed
		]);

		$questLog->update($request->all());

		// Log activity if bonus xp was updated

		// If we care completing a quest see if the user levels up
		if ($request->input('status') === 'Completed')
		{
			// Check if completed_at has already been set. If so, skip the update
			if (!$questLog->completed_at)
			{
				$questLog->completed_at = now();
				$questLog->save();

				// Log this happened
				activity()
					->causedBy(auth()->user())
					->performedOn($questLog)
					->log('Quest completed');
			}

			if ($request->has('xp_bonus'))
			{
				activity()
					->causedBy(auth()->user())
					->performedOn($questLog)
					->log('Quest log bonus XP updated!');
			}

			$user = $questLog->user;
			$user->levelUp();
		}

		// Log Quest Log Update
		activity()
			->causedBy(auth()->user())
			->performedOn($questLog)
			->log('Quest log updated');

		return redirect()->route('users.quest-logs', $questLog->user_id)
			->with('success', 'Quest log updated!');
	}

	// Helper method to determine the status color

	public function review(QuestLog $questLog): View
	{
		return view('quest-logs.review', compact('questLog'));
	}
}
