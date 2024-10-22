<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    //
    protected $fillable = [
        'forum_id',
        'user_id',
        'post_content',
        'post_date',
    ];

    // Relasi ke Forum
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}