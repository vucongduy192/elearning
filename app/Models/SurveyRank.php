<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyRank extends Model
{
    protected $table = 'survey_ranks';

    protected $fillable = [
        'level', 'duration', 'free', 'student_id'
    ];
}
