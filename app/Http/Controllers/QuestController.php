<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quest;  // Replace with your Quest model path
use App\Models\Category;
use App\Models\Campaign;

class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Quest::with('category');

        // Filtering by Category (Optional)
        if ($request->filled('category')) { // Check if category is filled (not empty)
            $query->where('category_id', $request->input('category'));
        }

        // Searching by Title
        if ($request->filled('search')) { // Check if search term is filled (not empty)
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $quests = $query->paginate(10); // Paginate the results (10 quests per page)

        $categories = Category::all(); // Get all categories for the filter dropdown

        return view('quests.index', compact('quests', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
		$campaigns = Campaign::all(); // Fetch all campaigns

		return view('quests.create', compact('categories', 'campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'points' => 'required|integer|min:1',
            'repeatable' => 'required|integer',
            'category_id' => 'required|integer',
            // Add validation for other fields as needed
        ]);

        $quest = Quest::create($request->all());

        return redirect()->route('quests.index')
                        ->with('success', 'Quest created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quest = Quest::find($id);

        if (!$quest) {
            return abort(404);
        }


		return view('quests.show', compact('quest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quest = Quest::find($id);

        if (!$quest) {
            return abort(404);
        }

		$categories = Category::all();
		$campaigns = Campaign::all(); // Fetch all campaigns

		return view('quests.edit', compact('quest', 'categories', 'campaigns'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $quest = Quest::find($id);

        if (!$quest) {
            return abort(404);
        }

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'points' => 'required|integer|min:1',
            'category_id' => 'required|integer',
            // Add validation for other fields as needed
        ]);

        $quest->update($request->all());

        return redirect()->route('quests.index')
                        ->with('success', 'Quest updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quest = Quest::find($id);

        if (!$quest) {
            return abort(404);
        }

        $quest->delete();

        return redirect()->route('quests.index')
            ->with('success', 'Quest deleted successfully!');

    }
        // QuestController.php
        public function accept(Quest $quest)
    {
        $user = auth()->user();

        // Check if the quest is repeatable and the user hasn't reached the limit
        if ($quest->repeatable === -1 || $user->questLogs()->where('quest_id', $quest->id)->count() < $quest->repeatable) {
            $user->questLogs()->create([
                'quest_id' => $quest->id,
                'status' => 'accepted', // Set the initial status to 'accepted'
            ]);
        } else {
            // Handle the case where the user has reached the repeat limit (optional)
        }

        return redirect()->route('quest-log.index')->with('success', 'Quest accepted!');
    }

}
