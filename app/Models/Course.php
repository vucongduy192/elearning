<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    const EASY = 1;
    const MEDIUM = 2;
    const HARD = 3;

    const THUMBNAIL_WIDTH = 360;
    const THUMBNAIL_HEIGHT = 180;

    protected $fillable = [
        'name', 'name_en', 'overview', 'price', 'level', 'thumbnail', 'courses_category_id', 'teacher_id', 'duration_id', 'partner_id'
    ];

    public static function getLevel($level_id)
    {
        $level_str = ['', 'Easy', 'Medium', 'Hard'];
        return $level_str[$level_id];
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function duration()
    {
        return $this->belongsTo('App\Models\Duration');
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
         return $this->hasMany('App\Models\Enroll', 'course_id', 'id');
     }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'course_id', 'id');
    }
}
