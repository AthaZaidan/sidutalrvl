<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'dob' => 'date',
            'start_period' => 'date',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . ($this->last_name ?? ''));
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id_role');
    }

    public function jobField()
    {
        return $this->belongsTo(JobField::class, 'job_field', 'id_jobfield');
    }

    public function subJobField()
    {
        return $this->belongsTo(SubJobField::class, 'sub_job_field', 'id_subjobfield');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level', 'id_educationlevel');
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class, 'user_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(UserFile::class, 'user_id', 'id')->where('deleted', 0);
    }

    public function languages()
    {
        return $this->hasMany(UserLanguage::class, 'id_user', 'id')->where('deleted', 0);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_listskill', 'user_id', 'skill_id');
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class, 'user_list_disability', 'user_id', 'user_disability');
    }

    public function ak1Applications()
    {
        return $this->hasMany(Ak1::class, 'user_id', 'id')->where('deleted_ak1', 0);
    }

    public function latestAk1()
    {
        return $this->hasOne(Ak1::class, 'user_id', 'id')->where('deleted_ak1', 0)->latest('id_ak1');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobVacancyApplicant::class, 'user_id', 'id');
    }

    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplicant::class, 'user_id', 'id');
    }

    public function trainingApplications()
    {
        return $this->hasMany(TrainingApplicant::class, 'user_id', 'id');
    }
}
