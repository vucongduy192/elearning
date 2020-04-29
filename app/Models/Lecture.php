<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'lectures';

    protected $fillable = [
        'name', 'slide', 'module_id'
    ];

    public function module()
    {
        return $this->belongsTo('App\Models\Module');
    }
}
