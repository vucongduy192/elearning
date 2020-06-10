<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyTeacher extends Model
{
    protected $table = 'survey_teachers';

    protected $fillable = [
        'teacher_id', 'student_id'
    ];
}
