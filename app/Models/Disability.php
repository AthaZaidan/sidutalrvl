<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    protected $table = 'disability';
    protected $primaryKey = 'id_disability';
    public $timestamps = false;
    protected $guarded = ['id_disability'];
}
