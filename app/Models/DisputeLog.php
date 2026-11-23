<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputeLog extends Model
{
    protected $table = 'dispute_log';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
