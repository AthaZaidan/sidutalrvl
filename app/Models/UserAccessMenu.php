<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccessMenu extends Model
{
    protected $table = 'user_access_menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
