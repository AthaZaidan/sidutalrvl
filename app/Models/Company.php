<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    protected $table = 'company';
    protected $primaryKey = 'id_company';
    public $timestamps = false;

    protected $guarded = ['id_company'];

    protected $hidden = [
        'password_company',
    ];

    protected function casts(): array
    {
        return [
            'password_company' => 'hashed',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->password_company;
    }

    public function getAuthPasswordName(): string
    {
        return 'password_company';
    }

    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class, 'badanusaha_company', 'id_badanusaha');
    }

    public function category()
    {
        return $this->belongsTo(CompanyCategory::class, 'category_company', 'id_category');
    }

    public function getDisplayNameAttribute(): string
    {
        $prefix = $this->badanUsaha?->name_badanusaha;
        return trim(($prefix ? $prefix . ' ' : '') . ($this->name_company ?? $this->email_company));
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'company_id', 'id_company')->where('deleted_vacancy', '0');
    }

    public function internships()
    {
        return $this->hasMany(Internship::class, 'company_id', 'id_company')->where('deleted_intern', '0');
    }

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'company_id', 'id_company');
    }

    public function wlkps()
    {
        return $this->hasMany(Wlkp::class, 'company_id', 'id_company');
    }

    public function serikats()
    {
        return $this->hasMany(Serikat::class, 'company_id', 'id_company');
    }
}
