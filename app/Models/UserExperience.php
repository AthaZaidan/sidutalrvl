<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $table = 'user_experience';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
