<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'name', 'overview', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function lectures()
    {
        return $this->hasMany('App\Models\Lecture')->select(['id', 'name', 'slide']);
    }
}
