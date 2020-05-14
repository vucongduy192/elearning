<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'title', 'thumbnail', 'summary', 'content', 'user_id'
    ];

    const THUMBNAIL_WIDTH = 450;
    const THUMBNAIL_HEIGHT = 350;
}
