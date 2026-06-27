<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_quizzes'      => Quiz::count(),
            'active_quizzes'     => Quiz::where('is_active', true)->count(),
            'total_submissions'  => Submission::count(),
            'today_submissions'  => Submission::whereDate('created_at', today())->count(),
        ];

        $recentSubmissions = Submission::with('quiz')
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSubmissions'));
    }
}
