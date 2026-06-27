<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('submissions')->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'question_count'  => 'required|integer|min:1|max:200',
            'answers'         => 'required|array',
            'answers.*'       => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $quiz = Quiz::create([
                'title'          => $request->title,
                'description'    => $request->description,
                'question_count' => $request->question_count,
                'is_active'      => $request->boolean('is_active', true),
            ]);

            foreach ($request->answers as $number => $answer) {
                QuizQuestion::create([
                    'quiz_id'         => $quiz->id,
                    'question_number' => $number,
                    'correct_answer'  => trim($answer),
                ]);
            }
        });

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz muvaffaqiyatli yaratildi!');
    }

    public function edit(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'answers'     => 'required|array',
            'answers.*'   => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $quiz) {
            $quiz->update([
                'title'       => $request->title,
                'description' => $request->description,
                'is_active'   => $request->boolean('is_active', true),
            ]);

            $quiz->questions()->delete();

            foreach ($request->answers as $number => $answer) {
                QuizQuestion::create([
                    'quiz_id'         => $quiz->id,
                    'question_number' => $number,
                    'correct_answer'  => trim($answer),
                ]);
            }

            $quiz->update(['question_count' => count($request->answers)]);
        });

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz muvaffaqiyatli yangilandi!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with('success', 'Quiz o\'chirildi.');
    }
}
