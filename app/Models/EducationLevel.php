<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    protected $table = 'education_level';
    protected $primaryKey = 'id_educationlevel';
    public $timestamps = false;
    protected $guarded = ['id_educationlevel'];
}
