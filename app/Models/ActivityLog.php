<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
