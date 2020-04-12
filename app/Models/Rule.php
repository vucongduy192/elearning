<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'category_rules';

    protected $fillable = [
        'cat_id1', 'cat_id2', 'weight'
    ];

    public function category1()
    {
        return $this->belongsTo('App\Models\Category', 'cat_id1');
    }

    public function category2()
    {
        return $this->belongsTo('App\Models\Category', 'cat_id2');
    }
}
