<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Quest;
use App\Models\QuestLog;
use DB;

class ReportController extends Controller
{
	public function index(Request $request): View
	{
		$user = $request->user();

		// Fetch data
		$quests = Quest::leftJoin('quest_logs', 'quests.id', '=', 'quest_logs.quest_id')
			->select(
				'quests.id',
				'quests.title',
				'quests.min_level',
				DB::raw('COUNT(CASE WHEN quest_logs.status = "Accepted" THEN 1 END) as accepted_count'),
				DB::raw('COUNT(CASE WHEN quest_logs.status = "Completed" THEN 1 END) as completed_count'),
				DB::raw('COUNT(CASE WHEN quest_logs.status = "Dropped" THEN 1 END) as dropped_count'),
				DB::raw('SUM(CASE WHEN quest_logs.status = "Completed" THEN quest_logs.minutes ELSE 0 END) as total_time_spent'),
				DB::raw('AVG(CASE WHEN quest_logs.status = "Completed" THEN quest_logs.minutes ELSE NULL END) as avg_time_spent')
			)
			->groupBy('quests.id', 'quests.title', 'quests.min_level')
			->orderBy('quests.min_level', 'asc')
			->orderBy('quests.title', 'asc')
			->get();

		return view('report.index', compact('quests'));
	}
}