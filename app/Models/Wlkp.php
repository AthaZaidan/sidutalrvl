<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wlkp extends Model
{
    protected $table = 'wlkp';
    protected $primaryKey = 'id_wlkp';
    public $timestamps = false;
    protected $guarded = ['id_wlkp'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_company');
    }
}
