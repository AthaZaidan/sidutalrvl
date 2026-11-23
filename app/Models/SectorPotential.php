<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectorPotential extends Model
{
    protected $table = 'sector_potential';
    protected $primaryKey = 'id_sector';
    public $timestamps = false;
    protected $guarded = ['id_sector'];
}
