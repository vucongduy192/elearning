<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = 'processes';

    protected $fillable = [
        'course_id', 'module_id', 'student_id'
    ];
}
