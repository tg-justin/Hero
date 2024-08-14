<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
	public function index(Request $request): View
	{
		// Fetch activities with sorting/filtering/pagination
		$activities = Activity::latest()
			->when($request->has('filter'), function($query) use ($request)
			{
				// ... (your existing filtering logic here) ...
			})
			->when($request->has('sort_by'), function($query) use ($request)
			{
				// ... (your existing sorting logic here) ...
			})
			->with('subject') // Eager load the 'subject' relationship
			->paginate(25);

		// Enhance activity data using the helper function
		//$activities->getCollection()->transform(function ($activity) {
		//     $activity->subject_display_name = $this->getSubjectDisplayName($activity->subject);
		//     return $activity;
		//  });

		return view('activity_logs.index', ['activities' => $activities]);
	}

	// app/Helpers/activity_helpers.php

	public function getSubjectDisplayName($subject): string
	{
		if (is_null($subject))
		{ // Check if $subject is null
			return "N/A"; // Or any other appropriate value
		}

		if ($subject instanceof Quest)
		{
			return $subject->title;
		}
		elseif ($subject instanceof QuestLog)
		{
			return $subject->quest->title;
		}
		else
		{
			return get_class($subject); // Fallback for other models
		}
	}
}