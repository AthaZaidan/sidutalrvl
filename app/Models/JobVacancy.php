<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $table = 'job_vacancy';
    protected $primaryKey = 'id_jobvacancy';
    public $timestamps = false;
    protected $guarded = ['id_jobvacancy'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_company');
    }

    public function jobField()
    {
        return $this->belongsTo(JobField::class, 'jobfield_vacancy', 'id_jobfield');
    }

    public function subJobField()
    {
        return $this->belongsTo(SubJobField::class, 'subjobfield_vacancy', 'id_subjobfield');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_vacancy', 'id_city');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level', 'id_educationlevel');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'jv_listskill', 'jv_id', 'skill_id');
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class, 'job_listdisability', 'job_vacancy_id', 'disability_id');
    }

    public function applicants()
    {
        return $this->hasMany(JobVacancyApplicant::class, 'jobvacancy_id', 'id_jobvacancy');
    }
}
