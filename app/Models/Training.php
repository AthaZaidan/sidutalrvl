<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';
    protected $primaryKey = 'id_training';
    public $timestamps = false;
    protected $guarded = ['id_training'];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_training', 'id_city');
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class, 'training_listdisability', 'training_id', 'disability_id');
    }

    public function applicants()
    {
        return $this->hasMany(TrainingApplicant::class, 'training_id', 'id_training');
    }
}
