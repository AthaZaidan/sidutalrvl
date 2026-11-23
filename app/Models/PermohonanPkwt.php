<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanPkwt extends Model
{
    protected $table = 'permohonan_pkwt';
    protected $primaryKey = 'id_pkwt';
    public $timestamps = false;
    protected $guarded = ['id_pkwt'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_company');
    }

    public function mediatorUser()
    {
        return $this->belongsTo(User::class, 'mediator', 'id');
    }
}
