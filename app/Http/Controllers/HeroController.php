<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('roles', function ($query) {
            $query->where('name', 'hero');
        });

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        $heroes = $query->get();

        return view('heroes.index', compact('heroes'));
    }


// Helper method to get status color (you can move this to a Trait or Helper class if you prefer)
    protected function getStatusColor($status)
    {
        return match ($status) {
            'In Progress' => 'bg-blue-200',
            'Completed' => 'bg-green-200',
            'Failed' => 'bg-red-200',
            'Expired' => 'bg-yellow-200',
            'Accepted' => 'bg-seance-200',  // Assuming 'seance' is defined in your config
            default => 'bg-gray-200',
        };
    }
}
