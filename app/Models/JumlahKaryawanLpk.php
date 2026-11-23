<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumlahKaryawanLpk extends Model
{
    protected $table = 'jumlahkaryawan_lpk';
    protected $primaryKey = 'id_jumlahkaryawan';
    public $timestamps = false;
    protected $guarded = ['id_jumlahkaryawan'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }
}
