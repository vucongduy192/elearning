<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'school', 'major', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function enrolled()
    {
        return $this->hasMany('App\Models\Enroll', 'student_id', 'id')->select(['id', 'course_id', 'student_id']);
    }

    public function survey()
    {
        return $this->hasMany('App\Models\Survey', 'student_id', 'id')->select(['id', 'courses_category_id', 'student_id']);
    }

    public function survey_ranks()
    {
        return $this->hasOne('App\Models\SurveyRank', 'student_id', 'id')->select(['id', 'partner_id', 'duration_id', 'free', 'level']);
    }
    
}
