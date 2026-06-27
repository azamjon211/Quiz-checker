<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    protected $fillable = ['quiz_id', 'student_name', 'score', 'total_questions'];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SubmissionAnswer::class)->orderBy('question_number');
    }

    public function getPercentageAttribute(): int
    {
        if ($this->total_questions === 0) return 0;
        return (int) round(($this->score / $this->total_questions) * 100);
    }

    public function getGradeAttribute(): string
    {
        $p = $this->percentage;
        if ($p >= 90) return 'A';
        if ($p >= 75) return 'B';
        if ($p >= 60) return 'C';
        if ($p >= 45) return 'D';
        return 'F';
    }

    public function getGradeColorAttribute(): string
    {
        return match ($this->grade) {
            'A' => 'emerald',
            'B' => 'blue',
            'C' => 'yellow',
            'D' => 'orange',
            default => 'rose',
        };
    }
}
