<?php

namespace App\Http\Controllers;

use App\Models\QuestLog;
use Illuminate\View\View;
use Illuminate\Http\Request;

// Import the View class

class ManagerDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $sortBy = $request->query('sort_by', 'completed_at'); // Default sorting by completed_at
        $sortDirection = $request->query('sort_direction', 'asc'); // Default ascending order

        $questLogs = QuestLog::where('status', 'Pending Review')
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        return view('manager.dashboard', compact('questLogs', 'sortBy', 'sortDirection'));
    }
}
