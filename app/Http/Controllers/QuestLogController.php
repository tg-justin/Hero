<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestLog;
use App\Models\User;
use App\Rules\ExcludeMimes;
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
	 * @return View
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
		// TODO: "$sortBy" is never used.
		$sortBy = $request->get('sort', 'status');
		$direction = $request->get('direction', 'asc');
		$questLogsQuery->orderByRaw("FIELD(status, 'Accepted', 'Completed', 'Dropped', 'Expired') $direction");

		// Pagination
		$questLogs = $questLogsQuery->paginate(); // default is 15 items per page

		return view('quest-logs.index', ['questLogs' => $questLogs, 'user' => $user]);
	}

	public function edit(QuestLog $questLog): View
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

		if (str_contains($questLog->quest->feedback_type, 'Required'))
		{
			$request->validate([
				'feedback' => 'required|string',
				'hours' => 'integer|min:0',
				'minutes' => 'integer|min:0',
				'files.*' => ['nullable', 'required_with:titles.*', 'file', new ExcludeMimes(['php', 'exe', 'msi']), 'max:2048'],
				'titles.*' => ['nullable', 'string', 'max:30'],
			]);
		}
		else
		{
			$request->validate([
				'feedback' => 'nullable|string',
				'hours' => 'integer|min:0',
				'minutes' => 'integer|min:0',
				'files.*' => ['nullable', 'required_with:titles.*', 'file', new ExcludeMimes(['php', 'exe', 'msi']), 'max:2048'],
				'titles.*' => ['nullable', 'string', 'max:30'],
			]);
		}

		// Calculate total minutes
		$totalMinutes = ($request->hours * 60) + $request->minutes;

		$questLog->update([
			'status' => 'Completed',
			'completed_at' => now(),
			'review' => $questLog->review == 1 ? 1 : $request->review ?? 0,
			'feedback' => $request->feedback,
			'feedback_type' => $questLog->quest->feedback_type,
			'minutes' => $totalMinutes,
		]);

		$this->handleFileUploads($request, $questLog);

		// If the status changed and is now complete
		// Email the quest creator if they have email notifications enabled
		if ($questLog->wasChanged('status') && $questLog->status === 'Completed' && $questLog->quest->notify_email)
		{
			$emails = explode(',', $questLog->quest->notify_email);

			// Ensure the array contains valid email addresses
			$validEmails = array_filter($emails, function ($email) {
				return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
			});

			$message = "{$questLog->user->name} has completed the quest '{$questLog->quest->title}'.";
			$reviewUrl = route('quest-logs.review', $questLog);

			$message .= "You can review the quest log here: $reviewUrl";

			// Send the email
			Mail::raw($message, function ($message) use ($validEmails) {
				$message
					->to($validEmails) // Send to multiple recipients
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
			'xp_awarded' => 'required|integer|min:0',
			'bonus_xp' => 'nullable|integer|min:0',
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

		return redirect()->route('manager.review')
			->with('success', 'Quest log #' . $questLog->id . ' updated! <a href="' . route('quest-logs.review', $questLog->id) . '">Make changes</a>');
	}

	// Helper method to determine the status color

	public function review(QuestLog $questLog): View
	{
		$valid_statuses = QuestLog::getStatuses();
		return view('quest-logs.review', compact('questLog', 'valid_statuses'));
	}

	public function indexForQuest(Quest $quest, Request $request)
	{
		$sortBy = $request->get('sort', 'completed_at');
		$sortDirection = $request->get('direction', 'desc');

		$questLogs = $quest->questLogs()
			->join('users', 'quest_logs.user_id', '=', 'users.id')
			->select('quest_logs.*', 'quest_logs.id as quest_log_id', 'users.name')
			->orderBy($sortBy, $sortDirection)
			->paginate(15); // Eager load the hero relationship

		$questLogs->each(function ($questLog) {
			// Strip HTML tags and calculate length
			$feedbackText = strip_tags($questLog->feedback);
			$length = strlen($feedbackText);

			// Assign a size category
			if ($length < 10) {
				$questLog->feedback_size = 'Tiny';
			} elseif ($length < 50) {
				$questLog->feedback_size = 'Small';
			} elseif ($length < 200) {
				$questLog->feedback_size = 'Medium';
			} else {
				$questLog->feedback_size = 'Large';
			}
		});
		return view('quest-logs.index-for-quest', [
			'quest' => $quest,
			'questLogs' => $questLogs,
			'sortBy' => $sortBy,
			'sortDirection' => $sortDirection,
		]);
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
	public function confirmDrop(QuestLog $questLog): View
	{
		// Authorize the user (make sure only the hero who owns the quest log can complete it)
		if (auth()->user()->id !== $questLog->user_id)
		{
			abort(403, 'Unauthorized');
		}

		return view('quest-logs.drop-confirm', compact('questLog'));
	}
	private function handleFileUploads(Request $request, $questLog): void
	{
		if ($request->hasFile('files'))
		{
			$files = $request->file('files');
			$titles = $request->input('titles', []);

			foreach ($files as $index => $file)
			{
				$originalTitle = $titles[$index] ?? '';
				$cleanTitle = cleanFilename($originalTitle);
				$cleanFilename = cleanFilename($file->getClientOriginalName());

				if (empty($cleanTitle))
				{
					$title = preg_replace('/[._-]+/', ' ', pathinfo($cleanFilename, PATHINFO_FILENAME));
					$filename = $cleanFilename;
				}
				else
				{
					$title = $originalTitle;
					$filename = $cleanTitle . '.' . pathinfo($cleanFilename, PATHINFO_EXTENSION);
				}

				$filename = pathinfo($filename, PATHINFO_FILENAME) . '-' .
					now()->format('Ymd-His') . '.' .
					pathinfo($filename, PATHINFO_EXTENSION);

				$path = $file->storeAs("feedback/{$questLog->quest->id}/$questLog->id", $filename, 'public');

				$questLog->files()->create([
					'title' => $title,
					'filename' => $filename,
					'path' => $path,
				]);
			}
		}
	}
}