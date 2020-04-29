<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    const EASY = 0;
    const MEDIUM = 1;
    const HARD = 2;

    const THUMBNAIL_WIDTH = 360;
    const THUMBNAIL_HEIGHT = 180;

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

    public function modules()
    {
        return $this->hasMany('App\Models\Module')->select(['id', 'name', 'overview']);
    }

    public function courses_category()
    {
        return $this->belongsTo('App\Models\Category');
    }

     public function num_enrolls()
     {
         return $this->hasMany('App\Models\Module', 'course_id', 'id');
     }
}
