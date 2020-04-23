<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    const EASY = 0;
    const MEDIUM = 1;
    const HARD = 2;

    protected $fillable = [
        'name', 'overview', 'price', 'level', 'thumbnail', 'courses_category_id', 'teacher_id',
    ];

    public static function getLevel($level_id)
    {
        $level_str = ['Easy', 'Medium', 'Hard'];
        return $level_str[$level_id];
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function lectures()
    {
        return $this->hasMany('App\Models\Lecture')->select(['id', 'name', 'slide']);
    }

    public function courses_category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    // public function enrolls()
    // {
    //     return $this->hasMany('App\Models\Enroll');
    // }
}
