<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelayananNik extends Model
{
    protected $table = 'pelayanan_nik';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
