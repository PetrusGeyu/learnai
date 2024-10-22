<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    //
    protected $fillable = [
        'course_id',
        'forum_topic',
    ];

    // Relasi ke Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}