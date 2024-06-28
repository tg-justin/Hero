<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Quest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
		$request->validate([
			'title' => 'required|string',
			'intro_text' => 'required|string',
			'directions_text' => 'required|string',
			'xp' => 'required|integer|min:1',
			'min_level' => 'required|integer|min:0',
			'category_id' => 'required|integer',
			// Add validation for other fields as needed
		]);

		// Get all request data
		$data = $request->all();
		$data['notify_email'] = $request->notify_email ?? 0;

		// Add the user_id to the data
		$data['user_id'] = auth()->user()->id;

		$quest = Quest::create($data);

		// log the activity
		activity()
			->causedBy(auth()->user())
			->performedOn($quest)
			->log('Quest created');

//        return redirect()->route('quests.index')
//            ->with('success', 'Quest created successfully!');

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
	public function show(Quest $quest):View
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

		return view('quests.edit', compact('quest', 'categories', 'campaigns','feedback_types'));
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
		$request->validate([
			'title' => 'required|string',
			'directions_text' => 'required|string',
			'xp' => 'required|integer|min:1',
			'category_id' => 'required|integer',
			// Add validation for other fields as needed
		]);
		$quest->notify_email = $request->notify_email ?? 0;
		$quest->update($request->all());

		// Log the update
		activity()
			->causedBy(auth()->user())
			->performedOn($quest)
			->log('Quest updated');

//        return redirect()->route('quests.index')
//            ->with('success', 'Quest updated successfully!');

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

		if ($request->isMethod('DELETE')) {
			if ($quest->questLogs()->exists()) {

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
			if(str_contains($quest->feedback_type, 'Required')){
				$review = 1;
			}else{
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

//        return redirect()->route('quest-log.index')->with('success', 'Quest accepted!');
		return redirect()->route('quests.show', $quest->id)->with('success', 'QUEST ACCEPTED!');
	}
}
