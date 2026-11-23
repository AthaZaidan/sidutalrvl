<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    protected $table = 'user_language';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
