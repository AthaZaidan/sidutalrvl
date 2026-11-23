<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanPp extends Model
{
    protected $table = 'permohonan_pp';
    protected $primaryKey = 'id_pp';
    public $timestamps = false;
    protected $guarded = ['id_pp'];

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
