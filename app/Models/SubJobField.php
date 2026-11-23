<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubJobField extends Model
{
    protected $table = 'sub_job_field';
    protected $primaryKey = 'id_subjobfield';
    public $timestamps = false;
    protected $guarded = ['id_subjobfield'];

    public function jobField()
    {
        return $this->belongsTo(JobField::class, 'id_job_field', 'id_jobfield');
    }
}
