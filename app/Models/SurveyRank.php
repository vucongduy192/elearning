<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyRank extends Model
{
    protected $table = 'survey_ranks';

    protected $fillable = [
        'level', 'duration_id', 'partner_id', 'free', 'student_id'
    ];

    public function duration()
    {
        return $this->belongsTo('App\Models\Duration', 'duration_id');
    }

    public function partner()
    {
        return $this->belongsTo('App\Models\Partner', 'partner_id');
    }
}
