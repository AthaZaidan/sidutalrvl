<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Lpk extends Authenticatable
{
    protected $table = 'lpk';
    protected $primaryKey = 'id_lpk';
    public $timestamps = false;

    protected $guarded = ['id_lpk'];

    protected $hidden = [
        'password_lpk',
    ];

    protected function casts(): array
    {
        return [
            'password_lpk' => 'hashed',
            'year_lpk' => 'date',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->password_lpk;
    }

    public function getAuthPasswordName(): string
    {
        return 'password_lpk';
    }

    public function sectorPotential()
    {
        return $this->belongsTo(SectorPotential::class, 'potential_sector_id', 'id_sector');
    }

    public function excellentVocational()
    {
        return $this->belongsTo(Vocational::class, 'exellent_vocational_id', 'id_vocational');
    }

    public function vocationals()
    {
        return $this->belongsToMany(Vocational::class, 'lpk_listvocational', 'lpk_id', 'vocational_id');
    }

    public function trainings()
    {
        return $this->hasMany(Training::class, 'lpk_id', 'id_lpk')->where('deleted_training', '0');
    }

    public function internships()
    {
        return $this->hasMany(Internship::class, 'lpk_id', 'id_lpk')->where('deleted_intern', '0');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'lpk_id', 'id_lpk')->where('deleted_certification', 0);
    }
}
