<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('is_active', true)
            ->withCount('submissions')
            ->latest()
            ->get();

        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        abort_if(!$quiz->is_active, 404);
        $quiz->load('questions');
        return view('quizzes.show', compact('quiz'));
    }
}
