<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['note', 'category_id'];

    protected $hidden = ['created_at', 'updated_at'];
}
