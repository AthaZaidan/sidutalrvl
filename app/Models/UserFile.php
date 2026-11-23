<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $table = 'user_files';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
