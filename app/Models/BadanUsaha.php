<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadanUsaha extends Model
{
    protected $table = 'badan_usaha';
    protected $primaryKey = 'id_badanusaha';
    public $timestamps = false;
    protected $guarded = ['id_badanusaha'];
}
