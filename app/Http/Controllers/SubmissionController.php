<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Submission;
use App\Models\SubmissionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    public function store(Request $request, Quiz $quiz)
    {
        abort_if(!$quiz->is_active, 403);

        $request->validate([
            'student_name' => 'required|string|max:100',
            'answers'      => 'required|array',
            'answers.*'    => 'nullable|string|max:255',
        ]);

        $quiz->load('questions');
        $correctMap = $quiz->questions->keyBy('question_number');

        $score = 0;
        $answerRows = [];

        foreach ($correctMap as $number => $question) {
            $studentAnswer = trim($request->answers[$number] ?? '');
            $isCorrect = mb_strtolower($studentAnswer) === mb_strtolower(trim($question->correct_answer))
                         && $studentAnswer !== '';
            if ($isCorrect) $score++;

            $answerRows[] = [
                'question_number' => $number,
                'student_answer'  => $studentAnswer !== '' ? $studentAnswer : null,
                'correct_answer'  => $question->correct_answer,
                'is_correct'      => $isCorrect,
            ];
        }

        $submission = DB::transaction(function () use ($quiz, $request, $score, $answerRows) {
            $submission = Submission::create([
                'quiz_id'         => $quiz->id,
                'student_name'    => $request->student_name,
                'score'           => $score,
                'total_questions' => count($answerRows),
            ]);

            foreach ($answerRows as $row) {
                SubmissionAnswer::create(array_merge($row, ['submission_id' => $submission->id]));
            }

            return $submission;
        });

        return redirect()->route('result.show', $submission);
    }

    public function show(Submission $submission)
    {
        $submission->load(['quiz', 'answers']);
        return view('results.show', compact('submission'));
    }
}
