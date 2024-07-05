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
	 * Display a paginated list of quests, with filtering, searching, and sorting capabilities.
	 *
	 * This method handles the main quest listing page, allowing users to:
	 *   - Filter quests by category.
	 *   - Search quests by title.
	 *   - Sort quests by minimum level, title, or experience points (XP).
	 *   - Paginate through results.
	 *
	 * It also enforces access restrictions based on user roles and levels:
	 *   - Level 0 heroes can only view level 0 quests (unless they are managers).
	 *   - Managers have unrestricted access to all quests.
	 *
	 * @param \Illuminate\Http\Request $request The incoming HTTP request, containing filtering, searching, and sorting parameters.
	 * @return \Illuminate\View\View The view for the quest listing page.
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
	 * Store a newly created quest in the database.
	 *
	 * This method handles the creation of new quests, including:
	 * - Validation of the request data.
	 * - Creation of the quest record in the database.
	 * - Handling of file uploads (if any).
	 * - Logging of the quest creation activity.
	 * - Redirection to the newly created quest's show page.
	 *
	 * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing quest data.
	 * @return \Illuminate\Http\RedirectResponse  A redirect to the quest's show page.
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
	 * Display the form for creating a new quest.
	 *
	 * This method retrieves necessary data (categories, campaigns, feedback types) and passes it to the view to render the quest creation form.
	 *
	 * @return \Illuminate\View\View The view for creating a new quest.
	 */
	public function create(): View
	{
		$feedback_types = Quest::getFeedbackTypes(); // Get the enum values FIRST
		$categories = Category::all();
		$campaigns = Campaign::all();

		return view('quests.create', compact('categories', 'campaigns', 'feedback_types'));
	}

	/**
	 * Handles the upload and storage of files associated with a quest.
	 *
	 * This method processes file uploads from the given request, associating them with the specified quest. It performs the following tasks:
	 * - Validates the existence of uploaded files.
	 * - Iterates through the uploaded files and their corresponding titles.
	 * - Sanitizes the titles for safe filename usage.
	 * - Stores the files in the public 'quests/<quest_id>' directory with sanitized filenames.
	 * - Creates file records in the database, linking them to the quest and storing their titles, filenames, and paths.
	 *
	 * @param  \Illuminate\Http\Request  $request  The HTTP request containing the uploaded files.
	 * @param  \App\Models\Quest  $quest  The quest to associate the files with.
	 * @return void
	 */
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

	/**
	 * Display the details of a specific quest.
	 *
	 * This method retrieves the specified quest from the database and passes it to the view for rendering.
	 * It allows users to view the details of a particular quest, including its title, description, objectives, rewards, etc.
	 *
	 * @param  \App\Models\Quest  $quest  The quest to be displayed.
	 * @return \Illuminate\View\View  The view containing the quest details.
	 */
	public function show(Quest $quest): View
	{
		return view('quests.show', compact('quest'));
	}

	/**
	 * Display the form for editing the specified quest.
	 *
	 * This method retrieves the quest along with associated data (categories, campaigns, feedback types) and passes it to the view to render the quest editing form.
	 *
	 * @param  \App\Models\Quest  $quest  The quest to be edited.
	 * @return \Illuminate\View\View  The view for editing the quest.
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
	 * Update the specified quest in storage.
	 *
	 * This method handles updating existing quests, including:
	 * - Validation of the request data.
	 * - Updating the quest record in the database.
	 * - Handling file uploads and removals.
	 * - Updating file titles for existing files.
	 * - Logging the quest update activity.
	 * - Redirecting to the quest's show page with a success message.
	 *
	 * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing the updated quest data.
	 * @param  \App\Models\Quest  $quest  The quest to be updated.
	 * @return \Illuminate\Http\RedirectResponse  A redirect to the updated quest's show page.
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
	 * Handles the deletion process for a quest.
	 *
	 * This method can be accessed via DELETE request to remove the quest and associated data.
	 * If accessed via GET request, it displays a confirmation view before deletion.
	 *
	 * @param \Illuminate\Http\Request $request The incoming HTTP request.
	 * @param \App\Models\Quest $quest The quest to be deleted.
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View A redirect response on successful deletion, or a confirmation view.
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

	/**
	 * Allows the authenticated user to accept a quest.
	 *
	 * This method handles the acceptance of a quest by a user, performing the following actions:
	 * - Checks if the quest is repeatable and if the user hasn't reached the repeat limit.
	 * - Creates a new quest log entry for the user, marking the quest as accepted.
	 * - Sets the initial status of the quest log to 'Accepted'.
	 * - Optionally handles the case where the user has reached the repeat limit.
	 * - Redirects the user back to the quest details page with a success message.
	 *
	 * @param  \App\Models\Quest  $quest  The quest to be accepted.
	 * @return \Illuminate\Http\RedirectResponse  A redirect to the quest details page.
	 */
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
}
