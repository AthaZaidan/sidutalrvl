<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanP3Lpk extends Model
{
    protected $table = 'kegiatan_p3_lpk';
    protected $primaryKey = 'id_kp3_lpk';
    public $timestamps = false;
    protected $guarded = ['id_kp3_lpk'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }
}
