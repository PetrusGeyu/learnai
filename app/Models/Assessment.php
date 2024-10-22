<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $fillable = [
        'course_id',
        'assessment_title',
        'assessment_type',
        'assessment_date',
        'difficulty_level'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}