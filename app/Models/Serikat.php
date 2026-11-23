<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serikat extends Model
{
    protected $table = 'serikat';
    protected $primaryKey = 'id_serikat';
    public $timestamps = false;
    protected $guarded = ['id_serikat'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_company');
    }
}
