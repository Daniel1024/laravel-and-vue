<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
}
