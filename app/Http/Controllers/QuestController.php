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
    public function index()
    {
        $quests = Quest::all();  // You can implement filtering logic here (optional)
        return view('quests.index', compact('quests'));
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
}
