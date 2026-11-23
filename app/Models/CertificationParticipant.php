<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationParticipant extends Model
{
    protected $table = 'list_certification';
    protected $primaryKey = 'id_lc';
    public $timestamps = false;
    protected $guarded = ['id_lc'];

    public function certification()
    {
        return $this->belongsTo(Certification::class, 'certification_id', 'id_certification');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
