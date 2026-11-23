<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterLog extends Model
{
    protected $table = 'register_log';
    protected $primaryKey = 'id_log';
    public $timestamps = false;
    protected $guarded = ['id_log'];
}
