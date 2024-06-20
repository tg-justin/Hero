<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Import the View class

class ManagerDashboardController extends Controller
{
	public function index(Request $request): View
	{
		$totalActiveHeroes = User::whereDoesntHave('roles', function($query)
		{
			$query->whereIn('name', ['manager', 'admin']); // Exclude users with these roles
		})->count();

		$today = Carbon::today();

		$startOfWeek = $today->startOfWeek();
		$startOfMonth = $today->startOfMonth();
		$today = Carbon::today();

		$unacceptedQuests = Quest::doesntHave('questLogs')->count();

		$unreviewedQuestLogs = QuestLog::where('status', 'pending_review')->count();

		$questsCompletedToday = QuestLog::where('status', 'completed')
			->whereDate('completed_at', $today)
			->count();
		/*dd($questsCompletedThisWeekQuery, $questsCompletedThisWeekQuery->getBindings());*/

		$questsCompletedThisWeek = QuestLog::where('status', 'completed')
			->whereBetween('completed_at', [$startOfWeek, $today])
			->count();

		$questsCompletedThisMonth = QuestLog::where('status', 'completed')
			->whereBetween('completed_at', [$startOfMonth, $today])
			->count();

		$topHeroes = User::withCount('questLogs')
			->orderBy('quest_logs_count', 'desc')
			->limit(5)
			->get();

		return view('manager.dashboard', [
			'totalActiveHeroes' => $totalActiveHeroes,
			'unacceptedQuests' => $unacceptedQuests,
			'unreviewedQuestLogs' => $unreviewedQuestLogs,
			'questsCompletedToday' => $questsCompletedToday,
			'questsCompletedThisWeek' => $questsCompletedThisWeek,
			'questsCompletedThisMonth' => $questsCompletedThisMonth,
			'topHeroes' => $topHeroes,
		]);
	}

	function review(Request $request): View
	{
		$sortBy = $request->query('sort_by', 'completed_at'); // Default sorting by completed_at
		$sortDirection = $request->query('sort_direction', 'asc'); // Default ascending order

		$questLogs = QuestLog::where('status', 'pending_review')
			->orderBy($sortBy, $sortDirection)
			->paginate(10);

		return view('manager.review', compact('questLogs', 'sortBy', 'sortDirection'));
	}
}
