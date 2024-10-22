<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = [
        'assessment_id',
        'question_text',
        'question_type',
        'correct_answer'
    ];

    // Relasi ke Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}