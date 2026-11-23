<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocational extends Model
{
    protected $table = 'vocational';
    protected $primaryKey = 'id_vocational';
    public $timestamps = false;
    protected $guarded = ['id_vocational'];
}
