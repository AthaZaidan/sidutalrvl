<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skill';
    protected $primaryKey = 'id_skill';
    public $timestamps = false;
    protected $guarded = ['id_skill'];
}
