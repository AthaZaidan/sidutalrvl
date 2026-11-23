<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';
    protected $primaryKey = 'id_school';
    public $timestamps = false;
    protected $guarded = ['id_school'];

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id', 'id_educationlevel');
    }
}
