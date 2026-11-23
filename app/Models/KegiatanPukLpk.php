<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanPukLpk extends Model
{
    protected $table = 'kegiatan_puk_lpk';
    protected $primaryKey = 'id_kpuk_lpk';
    public $timestamps = false;
    protected $guarded = ['id_kpuk_lpk'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }
}
