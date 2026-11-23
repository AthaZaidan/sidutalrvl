<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDesiredJob extends Model
{
    protected $table = 'user_desired_job';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'location', 'id_city');
    }
}
