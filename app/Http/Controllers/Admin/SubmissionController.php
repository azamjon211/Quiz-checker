<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Submission;

class SubmissionController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        $submissions = Submission::with('quiz')
            ->when(request('quiz_id'), fn($q) => $q->where('quiz_id', request('quiz_id')))
            ->latest()
            ->paginate(20);

        return view('admin.submissions.index', compact('submissions', 'quizzes'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['quiz', 'answers']);
        return view('admin.submissions.show', compact('submission'));
    }
    public function destroy(Submission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Natija muvaffaqiyatli o\'chirildi.');
    }
}
