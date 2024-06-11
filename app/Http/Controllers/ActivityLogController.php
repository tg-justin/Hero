<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {

        // Fetch activities (with optional sorting/filtering/pagination)
        $activities = Activity::latest()->get();

        // Enhance activity data using the helper function
        $activities->transform(function ($activity) {
            $activity->subject_display_name = $this->getSubjectDisplayName($activity->subject);
            return $activity;
        });

        return view('activity_logs.index', ['activities' => $activities]);
    }
    // app/Helpers/activity_helpers.php


    public function getSubjectDisplayName($subject)
    {
        if (is_null($subject)) { // Check if $subject is null
            return "N/A"; // Or any other appropriate value
        }

        if ($subject instanceof \App\Models\Quest) {
            return $subject->title;
        } elseif ($subject instanceof \App\Models\QuestLog) {
            return $subject->quest->title;
        } else {
            return get_class($subject); // Fallback for other models
        }
    }


}
