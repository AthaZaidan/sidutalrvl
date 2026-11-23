<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'major';
    protected $primaryKey = 'id_major';
    public $timestamps = false;
    protected $guarded = ['id_major'];
}
