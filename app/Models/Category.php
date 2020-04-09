<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'course_categories';

    protected $fillable = [
        'name', 'overview', 'thumbnail'
    ];
}
