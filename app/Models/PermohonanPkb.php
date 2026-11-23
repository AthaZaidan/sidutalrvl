<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanPkb extends Model
{
    protected $table = 'permohonan_pkb';
    protected $primaryKey = 'id_pkb';
    public $timestamps = false;
    protected $guarded = ['id_pkb'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_company');
    }

    public function statusModal()
    {
        return $this->belongsTo(CompanyStatusModal::class, 'status_modal_company', 'id');
    }

    public function mediatorUser()
    {
        return $this->belongsTo(User::class, 'mediator', 'id');
    }
}
