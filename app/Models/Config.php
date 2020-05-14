<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';
    const PLACEHOLDER_THUMBNAIL = '/images/thumbnail_placeholder.png';
    const PLACEHOLDER_AVATAR = '/images/user_placeholder.png';

}
