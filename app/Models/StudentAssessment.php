<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssessment extends Model
{
    //
    protected $fillable = [
        'user_id',
        'assessment_id',
        'score',
        'feedback'
    ];

    // Relasi ke User (Student)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}