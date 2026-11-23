<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobField extends Model
{
    protected $table = 'job_field';
    protected $primaryKey = 'id_jobfield';
    public $timestamps = false;
    protected $guarded = ['id_jobfield'];

    public function subJobFields()
    {
        return $this->hasMany(SubJobField::class, 'id_job_field', 'id_jobfield')->where('deleted_subjobfield', '0');
    }
}
