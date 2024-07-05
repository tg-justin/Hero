<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Quest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

// Replace with your Quest model path

class QuestController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\View\View
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
		if (auth()->check())
		{
			$user = auth()->user();
			if ($user->level == 0 && !$user->hasRole('manager'))
			{
				// Level 0 heroes see only level 0 quests
				$query->where('min_level', '=', 0);
			}
		}

		// Sorting Logic
		$sortBy = $request->get('sort');
		$direction = $request->get('direction', 'asc');

		if ($sortBy && in_array($sortBy, ['min_level', 'title', 'xp']))
		{ // Validate sorting column
			$query->orderBy($sortBy, $direction);
		}

		// Pagination (After Sorting!)
		$quests = $query->paginate(25);

		$categories = Category::all();

		return view('quests.index', compact('quests', 'categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$rules = [
			'title' => 'required|string',
			'directions_text' => 'required|string',
			'xp' => 'required|integer|min:1',
			'category_id' => 'required|integer',
			'files.*' => ['nullable', 'required_with:titles.*', 'file', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,csv,xls,xlsx', 'max:2048'],
			'titles.*' => ['nullable', 'required_with:files.*', 'string', 'max:255'],
		];

		$request->validate($rules);

		// Get all request data
		$request['notify_email'] = $request->notify_email ?? 0;

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
		$feedback_types = Quest::getFeedbackTypes(); // Get the enum values FIRST
		$categories = Category::all();
		$campaigns = Campaign::all();

		return view('quests.create', compact('categories', 'campaigns', 'feedback_types'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Quest $quest
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
	 * @param int $id
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
	 * @param \App\Models\Quest $quest
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Quest $quest): RedirectResponse
	{
		$rules = [
			'title' => 'required|string',
			'directions_text' => 'required|string',
			'xp' => 'required|integer|min:1',
			'category_id' => 'required|integer',
			'files.*' => ['nullable', 'required_with:titles.*', 'file', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,csv,xls,xlsx', 'max:2048'],
			'titles.*' => ['nullable', 'required_with:files.*', 'string', 'max:150'],
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
					Storage::delete($file->path); // Delete from storage
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
	 * @param \App\Models\Quest $quest
	 *
	 * @return void
	 */
	public function destroy(Request $request, Quest $quest): RedirectResponse|View
	{
		if ($request->isMethod('DELETE'))
		{
			if ($quest->questLogs()->exists())
			{
				return redirect()->route('quests.show', $quest)->with('error', 'Cannot delete quest with associated quest logs.');
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
		else
		{
			//TODO: Handle the case where the user has reached the repeat limit (optional)
		}
		return redirect()->route('quests.show', $quest->id)->with('success', 'QUEST ACCEPTED!');
	}

	private function handleFileUploads($request, $quest)
	{
		if ($request->hasFile('files'))
		{
			$titles = $request->input('titles');

			foreach ($request->file('files') as $index => $file)
			{
				$title = $titles[$index];

				// Sanitize the title for the filename
				$filename = Str::slug($title, '-');

				// Add the extension back
				$filename .= '.' . $file->getClientOriginalExtension();

				$path = $file->storeAs("quests/{$quest->id}", $filename, 'public');

				$quest->files()->create([
					'title' => $title, // Save the original title
					'filename' => $filename,
					'path' => $path,
				]);
			}
		}
	}
}
