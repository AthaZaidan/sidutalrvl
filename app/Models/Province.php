<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $primaryKey = 'id_prov';
    public $timestamps = false;
    protected $guarded = ['id_prov'];

    public function cities()
    {
        return $this->hasMany(City::class, 'prov_id', 'id_prov');
    }
}
