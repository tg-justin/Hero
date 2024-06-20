<?PHP

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	// DashboardController.php

	public function index(Request $request)
	{
		$userQuestLog = auth()->user()->questLogs();

		// Top Heroes (by totalxp)
		$topHeroes = User::whereHas('roles', function($query)
		{
			$query->where('name', 'hero');
		})
			->withCount('completedQuests') // Eager load the count of completed quests
			->orderByDesc(
				QuestLog::select(DB::raw('sum(xp_awarded + COALESCE(xp_bonus, 0)) as total_xp'))
					->whereColumn('user_id', 'users.id') // Make sure you're comparing with users.id from the main query
					->where('status', 'completed')
					->limit(1)
			)
			->take(5)
			->get();

		// Leaderboard (by totalxp)
		$leaderboard = User::whereHas('roles', function($query)
		{
			$query->where('name', 'hero');
		})
			->withCount('completedQuests')
			->orderByDesc(
				QuestLog::select(DB::raw('sum(xp_awarded + COALESCE(xp_bonus, 0)) as total_xp'))
					->whereColumn('user_id', 'users.id') // Make sure you're comparing with users.id from the main query
					->where('status', 'completed')
					->limit(1)
			)
			->get();

		// Total Quests by Category
		$questsByCategory = Quest::select('category_id', DB::raw('count(*) as total'))
			->with('category')
			->groupBy('category_id')
			->get();

		// News/Announcements (replace with your actual logic)
		$news = [
			'Quest Board will be down for upgrades on June, 12th at 5:30pm (CDT)',
		];

		return view('dashboard', compact('userQuestLog', 'topHeroes', 'leaderboard', 'questsByCategory', 'news'));
	}
}
