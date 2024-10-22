<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    //
    protected $fillable = [
        'user_id',
        'course_id',
        'completion_percentage',
    ];

    // Relasi ke User (Student)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}