<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Quest;
use App\Rules\ExcludeMimes;
use App\Rules\ExplodeTrim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

// Replace with your Quest model path

class QuestController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 *
	 * @return View
	 */
	public function index(Request $request): View
	{
		$query = Quest::with('category');

		// Filtering by Category
		if ($request->filled('category'))
		{
			$query->where('category_id', $request->input('category'));
		}

		// Searching by Title
		if ($request->filled('search'))
		{
			$query->where('title', 'like', '%' . $request->input('search') . '%');
		}

		// Limit by hero level if the user is authenticated and not a manager
//        if (auth()->check() && !auth()->user()->hasRole('manager')) {
//            $query->where('min_level', '<=', auth()->user()->level);
//        }

		// Limit Level 0 Heroes to Level 0 Quests, unless they are a manager.
		$user = auth()->user();
		if (auth()->check())
		{

			if ($user->level == 0 && !$user->hasRole('manager'))
			{
				// Level 0 heroes see only level 0 quests
				$query->where('min_level', '=', 0);
			}
		}

		if(!$user->hasRole('manager')){
			$query->where('status', '=', 'Active');
		}

		// Sorting Logic
		$sortBy = $request->get('sort');
		$direction = $request->get('direction', 'asc');

		if (in_array($sortBy, ['min_level', 'title', 'xp']))
		{ // Validate sorting column
			$query->orderBy($sortBy, $direction);
		}

		// Determine if completed quests should be shown
		$showCompleted = $request->has('show_completed');

		// Fetch quests with additional relationship for completed quest check
		$quests = $query->with([
			'questLogs' => function($query)
			{
				$query->where('user_id', auth()->id())
					->whereIn('status', ['Completed']);
			},
		])
			->when(!$showCompleted, function($query)
			{ // Exclude completed quests if not showing
				$query->whereDoesntHave('questLogs', function($query)
				{
					$query->where('user_id', auth()->id())
						->whereIn('status', ['Completed']);
				});
			})
			->paginate(25);

		$categories = Category::all();

		return view('quests.index', compact('quests', 'categories', 'showCompleted'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$rules = [
			'title' => 'required|string',
			'directions_text' => 'required|string',
			'xp' => 'required|integer|min:1',
			'category_id' => 'required|integer',
			'notify_email' => ['nullable', new ExplodeTrim('email')],
			'files.*' => ['nullable', 'required_with:titles.*', 'file', new ExcludeMimes(['php', 'exe', 'msi']), 'max:2048'],
			'titles.*' => ['nullable', 'string', 'max:30'],
		];

		$request->validate($rules);

		// Add the user_id to the data
		$request['user_id'] = auth()->user()->id;

		$quest = Quest::create($request->except('files', 'titles'));

		$this->handleFileUploads($request, $quest);

		// log the activity
		activity()
			->causedBy(auth()->user())
			->performedOn($quest)
			->log('Quest created');

		return redirect()->route('quests.show', $quest->id)->with('success', 'QUEST CREATED!');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create(): View
	{
		$quest = NULL;
		$feedbackTypes = Quest::getFeedbackTypes(); // Get the enum values FIRST
		$categories = Category::all();
		$campaigns = Campaign::all();

		return view('quests.create', compact('quest', 'categories', 'campaigns', 'feedbackTypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Quest $quest
	 *
	 * @return View
	 */
	public function show(Quest $quest): View
	{
		return view('quests.show', compact('quest'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Quest $quest
	 *
	 * @return View
	 */
	public function edit(Quest $quest): View
	{
		$categories = Category::all();
		$campaigns = Campaign::all(); // Fetch all campaigns
		$feedback_types = Quest::getFeedbackTypes(); // Get the enum values FIRST
		$quest->load('files');

		return view('quests.edit', compact('quest', 'categories', 'campaigns', 'feedback_types'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param Quest $quest
	 *
	 * @return RedirectResponse
	 */
	public function update(Request $request, Quest $quest): RedirectResponse
	{
		$rules = [
			'title' => 'required|string',
			'directions_text' => 'required|string',
			'xp' => 'required|integer|min:1',
			'category_id' => 'required|integer',
			'notify_email' => ['nullable', new ExplodeTrim('email')],
			'files.*' => ['nullable', 'required_with:titles.*', 'file', new ExcludeMimes(['php', 'exe', 'msi']), 'max:2048'],
			'titles.*' => ['nullable', 'string', 'max:30'],
		];

		$request->validate($rules);

		// Update quest log
		$quest->update($request->except('files', 'titles', 'existing_files'));

		// Handle file removals
		if ($request->has('remove_files'))
		{
			foreach ($request->input('remove_files') as $fileId)
			{
				$file = $quest->files()->find($fileId);
				if ($file)
				{
					Storage::disk('public')->delete($file->path);
					$file->delete();              // Delete from database
				}
			}
		}

		$this->handleFileUploads($request, $quest);

		if ($request->has('existing_files'))
		{
			foreach ($request->input('existing_files') as $fileId => $data)
			{
				$file = $quest->files()->find($fileId);
				if ($file)
				{
					$file->update(['title' => $data['title']]);
				}
			}
		}

		// Log the update
		activity()
			->causedBy(auth()->user())
			->performedOn($quest)
			->log('Quest updated');

		return redirect()->route('quests.show', $quest->id)->with('success', 'QUEST UPDATED!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Request $request
	 * @param Quest $quest
	 *
	 * @return RedirectResponse|View
	 */
	public function destroy(Request $request, Quest $quest): RedirectResponse|View
	{
		if ($request->isMethod('DELETE'))
		{
			if ($quest->questLogs()->exists())
			{
				return redirect()->route('quests.show', $quest)->with('error', 'Cannot delete quest with associated quest logs.');
			}

			// Delete associated files
			foreach ($quest->files as $file) {
				Storage::disk('public')->delete($file->path);
				$file->delete();
			}

			$quest->delete();

			return redirect()->route('quests.index')->with('success', 'Quest deleted successfully.');
		}
		return view('quests.confirm-delete', compact('quest'));
	}

	// QuestController.php
	public function accept(Quest $quest): RedirectResponse
	{
		$user = auth()->user();

		// Check to see if the user dropped the quest previously
		$droppedQuest = $user->questLogs()->where('quest_id', $quest->id)->where('status', 'Dropped')->first();
		if ($droppedQuest)
		{
			$droppedQuest->update([
				'status' => 'Accepted',
				'accepted_at' => NOW(),
			]);

			return redirect()->route('quests.show', $quest->id)->with('success', 'QUEST ACCEPTED!');
		}

		// Check if the quest is repeatable and the user hasn't reached the limit
		if ($quest->repeatable === 0 || $user->questLogs()->where('quest_id', $quest->id)->count() < $quest->repeatable)
		{
			if (str_contains($quest->feedback_type, 'Required'))
			{
				$review = 1;
			}
			else
			{
				$review = 0;
			}

			$user->questLogs()->create([
				'quest_id' => $quest->id,
				'xp_awarded' => $quest->xp,
				'review' => $review,
				'accepted_at' => NOW(),
				'status' => 'Accepted', // Set the initial status to 'Accepted'
			]);
		}
		//TODO: Handle the case where the user has reached the repeat limit (optional)

		return redirect()->route('quests.show', $quest->id)->with('success', 'QUEST ACCEPTED!');
	}

	public function duplicate(Quest $quest)
	{
		$duplicateQuest = $quest->replicate(); // Create a copy of the Quest model
		$duplicateQuest->title .= ' (COPY)';   // Add "(COPY)" to the title

		return view('quests.create', [
			'quest' => $duplicateQuest,  // Pass the duplicate to the create view
			'feedbackTypes' => Quest::getFeedbackTypes(), // Get the enum values
			'categories' => Category::all(),
			'campaigns' => Campaign::all()
		]);
	}

	private function handleFileUploads($request, $quest): void
	{
		if ($request->hasFile('files'))
		{
			$files = $request->file('files');
			$titles = $request->input('titles', []); // Default empty array if no titles are provided

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

				$path = $file->storeAs("quests/$quest->id", $filename, 'public');

				$quest->files()->create([
					'title' => $title, // Use sanitized title in database
					'filename' => $filename,   // Use sanitized filename for storage
					'path' => $path,
				]);
			}
		}
	}
}