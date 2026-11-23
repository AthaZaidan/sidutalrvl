<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancyApplicant extends Model
{
    protected $table = 'list_applicantjv';
    protected $primaryKey = 'id_listapplicant';
    public $timestamps = false;
    protected $guarded = ['id_listapplicant'];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'jobvacancy_id', 'id_jobvacancy');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
