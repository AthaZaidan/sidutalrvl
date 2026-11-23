<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendalaLpk extends Model
{
    protected $table = 'kendala_lpk';
    protected $primaryKey = 'id_kendala_lpk';
    public $timestamps = false;
    protected $guarded = ['id_kendala_lpk'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }
}
