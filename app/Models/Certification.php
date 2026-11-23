<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $table = 'certification';
    protected $primaryKey = 'id_certification';
    public $timestamps = false;
    protected $guarded = ['id_certification'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }

    public function vocational()
    {
        return $this->belongsTo(Vocational::class, 'vocational_id', 'id_vocational');
    }

    public function participants()
    {
        return $this->hasMany(CertificationParticipant::class, 'certification_id', 'id_certification')->where('deleted_lc', 0);
    }
}
