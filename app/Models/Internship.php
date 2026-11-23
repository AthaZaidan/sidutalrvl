<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $table = 'internship';
    protected $primaryKey = 'id_intern';
    public $timestamps = false;
    protected $guarded = ['id_intern'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_company');
    }

    public function lpk()
    {
        return $this->belongsTo(Lpk::class, 'lpk_id', 'id_lpk');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_intern', 'id_city');
    }

    public function subJobField()
    {
        return $this->belongsTo(SubJobField::class, 'subjobfield_intern', 'id_subjobfield');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'min_edu_level', 'id_educationlevel');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'in_listskill', 'in_id', 'skill_id');
    }

    public function applicants()
    {
        return $this->hasMany(InternshipApplicant::class, 'intern_id', 'id_intern');
    }

    public function getOrganizerNameAttribute(): string
    {
        if ($this->company_id && $this->company) {
            return $this->company->display_name;
        }
        if ($this->lpk_id && $this->lpk) {
            return $this->lpk->name_lpk ?? 'LPK';
        }
        return 'Penyelenggara';
    }
}
