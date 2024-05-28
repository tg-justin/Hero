<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QuestLog;

class QuestLogController extends Controller
{
    /**
     * Display the user's quest log.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Eager load quest log entries with associated quest data
        $acceptedQuests = auth()->user()->questLogs()->where('status', 'Accepted')->with('quest')->get();
        $exceptionRequests = auth()->user()->questLogs()->where('status', 'Requested Exception')->with('quest')->get();
        $completedQuests = auth()->user()->questLogs()->where('status', 'Completed')->with('quest')->get();

        // Add statusColor to each questLog
        $acceptedQuests = $acceptedQuests->map(function ($questLog) {
            $questLog->statusColor = 'bg-seance-200';
            return $questLog;
        });

        $exceptionRequests = $exceptionRequests->map(function ($questLog) {
            $questLog->statusColor = 'bg-yellow-200';
            return $questLog;
        });

        $completedQuests = $completedQuests->map(function ($questLog) { // Changed $quest to $questLog
            $questLog->statusColor = 'bg-green-200';
            return $questLog;
        });

        return view('quests.quest-log', compact('acceptedQuests', 'exceptionRequests', 'completedQuests', 'user'));
    }


    public function indexForUser(User $user, Request $request)
    {
        $questLogs = $user->questLogs()->with('quest.category');

        // Sorting logic
        $sortBy = $request->get('sort', 'status'); // Default sort by status
        $direction = $request->get('direction', 'asc'); // Default ascending

        if ($sortBy === 'status') {
            $questLogs->orderByRaw("FIELD(status, 'requested_exception', 'accepted', 'completed', 'failed') $direction");
        } else {
            // Handle sorting by other columns (quest.title, xp_awarded, xp_bonus)
            $questLogs->join('quests', 'quest_logs.quest_id', '=', 'quests.id') // Join quests table
            ->orderBy("$sortBy", $direction); // Order by quest columns
        }

        $questLogs = $questLogs->get();

        $questLogs = $questLogs->map(function ($questLog) {
            $questLog->statusColor = $this->getStatusColor($questLog->status);
            return $questLog;
        });

        return view('quests.quest-logs', ['questLogs' => $questLogs, 'user' => $user]);
    }

    public function edit(QuestLog $questLog)
    {
        // Authorize the user (e.g., using a middleware or policy)
        return view('quest-logs.edit', compact('questLog'));

    }

    public function update(Request $request, QuestLog $questLog)
    {
        // Authorize the user (e.g., using a middleware or policy)

        $request->validate([
            'status' => 'required|in:accepted,inProgress,completed,failed', // Add other validation rules as needed
        ]);

        $questLog->update($request->all());

        return redirect()->route('users.quest-logs', $questLog->user_id)
            ->with('success', 'Quest log updated successfully!');
        return redirect()->route('users.quest-logs', $questLog->user_id)->with('success', 'Quest log updated!');
    }


    // Helper method to determine the status color
    protected function getStatusColor($status)
    {
        return match ($status) {
            'In Progress' => 'bg-blue-200', // Added bg-
            'Completed' => 'bg-green-200',  // Added bg-
            'Failed' => 'bg-red-200',      // Added bg-
            'Requested Exception' => 'bg-yellow-200',  // Added bg- (if applicable)
            'Accepted' => 'bg-seance-200',  // Assuming 'seance' is defined in your config
            default => 'bg-gray-200',      // Added bg-
        };
    }

}
