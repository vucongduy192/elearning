<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'lectures';

    protected $fillable = [
        'name', 'slide', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
