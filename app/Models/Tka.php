<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tka extends Model
{
    protected $table = 'tka';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
