<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';

    protected $fillable = [
        'workplace', 'expert', 'user_id'
    ];

    const TEACHER_ADMIN_ID = 1;     # course created by admin assign to TEACHER_ADMIN

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
