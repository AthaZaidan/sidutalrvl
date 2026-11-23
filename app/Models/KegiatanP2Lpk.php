<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanP2Lpk extends Model
{
    protected $table = 'kegiatan_p2_lpk';
    protected $primaryKey = 'id_kp2_lpk';
    public $timestamps = false;
    protected $guarded = ['id_kp2_lpk'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }
}
