<?php

namespace App\Http\Controllers;

use App\Models\QuestLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
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
		$completedQuests = auth()->user()->questLogs()->where('status', 'Completed')->with('quest')->get();

		return view('quest-logs.quest-log', compact('acceptedQuests', 'completedQuests', 'user'));
	}

	public function indexForUser(User $user, Request $request): View
	{
		$questLogsQuery = $user->questLogs()->with('quest.category'); // Initialize query

		// Sorting logic (same as before)
		$sortBy = $request->get('sort', 'status');
		$direction = $request->get('direction', 'asc');
		$questLogsQuery->orderByRaw("FIELD(status, 'Accepted', 'Completed', 'Dropped', 'Expired') $direction");

		// Pagination
		$questLogs = $questLogsQuery->paginate(15); // 15 items per page


		return view('quest-logs.index', ['questLogs' => $questLogs, 'user' => $user]);
	}


	public function edit(QuestLog $questLog) :View
	{
		$valid_statuses = QuestLog::getStatuses();
		// Authorize the user (e.g., using a middleware or policy)
		return view('quest-logs.edit', compact('questLog', 'valid_statuses'));
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

		if(str_contains($questLog->quest->feedback_type, 'Required')){
			$request->validate([
				'feedback' => 'required|string',
				'minutes => required|integer',
			]);
		}else{
			$request->validate([
				'feedback' => 'nullable|string',
				'minutes => required|integer',
			]);
		}

		$questLog->update([
			'status' => 'Completed',
			'completed_at' => now(),
			'review' => $questLog->review == 1 ? 1 : $request->review ?? 0,
			'feedback' => $request->feedback,
			'feedback_type' => $questLog->quest->feedback_type,
			'minutes' => $request->minutes,
		]);

		// If the status changed and is now complete
		// Send an email to the quest creator if they have email notifications enabled
		if ($questLog->wasChanged('status') && $questLog->status === 'Completed' && $questLog->quest->notify_email) {
			$questCreator = $questLog->quest->user;

			$message = "{$questLog->user->name} has completed the quest '{$questLog->quest->title}'.";
			$reviewUrl = route('quest-logs.review', $questLog);

			$message .= "You can review the quest log here: $reviewUrl";

			// Send the email
			Mail::raw($message, function ($message) use ($questCreator) {
				$message
					->to($questCreator->email)
					->subject('Quest Completion');
			});
		}

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
		$valid_statuses = QuestLog::getStatuses();

		$request->validate([
			'status' => [
				'required',
				Rule::in($valid_statuses),
			],
		]);

		$questLog->update($request->all());

		// Log activity if bonus xp was updated

		// If we care completing a quest see if the user levels up
		if ($request->input('status') === 'Completed')
		{
			// Check if completed_at has already been set. If so, skip the update
			if (empty($questLog->reviewed_at))
			{
				$questLog->reviewed_at = now();
				$questLog->reviewer_id = auth()->user()->id;
				$questLog->save();

				// Log this happened
				activity()
					->causedBy(auth()->user())
					->performedOn($questLog)
					->log('Quest completed');
			}

			if ($questLog->wasChanged('xp_bonus'))
			{
				activity()
					->causedBy(auth()->user())
					->performedOn($questLog)
					->log('Quest log bonus XP updated!');

				$user = $questLog->user;
				$user->levelUp();
			}


		}

		// Log Quest Log Update
		activity()
			->causedBy(auth()->user())
			->performedOn($questLog)
			->log('Quest log updated');

		return redirect()->route('quest-logs.review', $questLog->id)
			->with('success', 'Quest log updated!');
	}

	// Helper method to determine the status color

	public function review(QuestLog $questLog): View
	{
		$valid_statuses = QuestLog::getStatuses();
		return view('quest-logs.review', compact('questLog' , 'valid_statuses'));
	}

	public function confirmDrop(QuestLog $questLog): View
	{
		// Authorize the user (make sure only the hero who owns the quest log can complete it)
		if (auth()->user()->id !== $questLog->user_id)
		{
			abort(403, 'Unauthorized');
		}

		return view('quest-logs.drop-confirm', compact('questLog'));
	}


	public function drop(QuestLog $questLog, Request $request): RedirectResponse
	{
		// Authorize the user (make sure only the hero who owns the quest log can complete it)
		if (auth()->user()->id !== $questLog->user_id)
		{
			abort(403, 'Unauthorized');
		}

		/*$validatedData = $request->validate([
			'feedback' => 'nullable|string',
		]);*/

		$questLog->update([
			'status' => 'Dropped',

		]);

		// Log this happened
		activity()
			->causedBy(auth()->user())
			->performedOn($questLog)
			->log('Quest Dropped');

		return redirect()->route('quests.index')->with('success', 'Quest dropped successfully.');

	}
}
