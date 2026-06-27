<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionAnswer extends Model
{
    protected $fillable = ['submission_id', 'question_number', 'student_answer', 'correct_answer', 'is_correct'];

    protected $casts = ['is_correct' => 'boolean'];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
}
