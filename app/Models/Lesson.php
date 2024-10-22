<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    protected $fillable = [
        'course_id',
        'lesson_title',
        'lesson_content'
    ];

    // Relasi ke Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}