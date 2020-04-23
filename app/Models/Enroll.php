<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Enroll extends Model
{
    protected $table = 'enrolls';

    protected $fillable = [
        'status', 'student_id', 'course_id'
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }
}
