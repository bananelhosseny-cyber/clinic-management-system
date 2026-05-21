<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // fillable fields for the Post model
    protected $fillable = [
        'name',
        'password',
        'id',
        'email',
    ];
}
