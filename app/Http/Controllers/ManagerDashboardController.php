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

		$unreviewedQuestLogs = QuestLog::where('review', '1')->where('reviewed_at', NULL)->count();

		$questsCompletedToday = QuestLog::where('status', 'Completed')
			->whereDate('completed_at', $today)
			->count();
		/*dd($questsCompletedThisWeekQuery, $questsCompletedThisWeekQuery->getBindings());*/

		$questsCompletedThisWeek = QuestLog::where('status', 'Completed')
			->whereBetween('completed_at', [$startOfWeek, $today])
			->count();

		$questsCompletedThisMonth = QuestLog::where('status', 'Completed')
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
		$questLogs = QuestLog::with('user', 'quest')
			->join('quests', 'quest_logs.quest_id', '=', 'quests.id')
			->join('users', 'quest_logs.user_id', '=', 'users.id')
			->select('quest_logs.*', 'users.name', 'quests.title')
			->where('review', '1')
			->where('reviewed_at', NULL);

		$sortBy = $request->get('sort');
		$direction = ($request->get('direction') === 'desc') ? 'desc' : 'asc';
		if (in_array($sortBy, ['users.name', 'quests.title', 'completed_at']))
		{
			$questLogs = $questLogs->orderBy($sortBy, $direction);
		}
		else
		{
			$questLogs = $questLogs->orderBy('completed_at', 'desc');
		}

		$questLogs = $questLogs->paginate(25);
		return view('manager.review', compact('questLogs'));
	}
}