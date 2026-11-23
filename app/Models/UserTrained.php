<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTrained extends Model
{
    protected $table = 'user_trained';
    protected $primaryKey = 'id_trained';
    public $timestamps = false;
    protected $guarded = ['id_trained'];
}
