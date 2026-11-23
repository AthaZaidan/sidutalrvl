<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KemitraanLpk extends Model
{
    protected $table = 'kemitraan_lpk';
    protected $primaryKey = 'id_kemitraan_lpk';
    public $timestamps = false;
    protected $guarded = ['id_kemitraan_lpk'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }
}
