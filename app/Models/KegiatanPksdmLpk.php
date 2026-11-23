<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanPksdmLpk extends Model
{
    protected $table = 'kegiatan_pksdm_lpk';
    protected $primaryKey = 'id_pksdm_lpk';
    public $timestamps = false;
    protected $guarded = ['id_pksdm_lpk'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }
}
