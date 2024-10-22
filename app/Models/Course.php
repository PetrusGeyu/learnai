<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //

    protected $fillable = [
        'course_name',
        'course_description'
    ];

    // Relasi ke Lesson
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
