<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'content', 'rating', 'course_id', 'student_id'
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
