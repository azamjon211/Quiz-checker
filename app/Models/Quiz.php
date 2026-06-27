<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = ['title', 'description', 'question_count', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('question_number');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
