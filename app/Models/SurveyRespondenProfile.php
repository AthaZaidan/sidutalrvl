<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyRespondenProfile extends Model
{
    protected $table = 'survey_responden_profiles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function service()
    {
        return $this->belongsTo(SurveyService::class, 'survey_service_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(SurveyRespondenAnswer::class, 'responden_id', 'id');
    }
}
