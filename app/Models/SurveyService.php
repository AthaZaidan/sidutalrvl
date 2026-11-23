<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyService extends Model
{
    protected $table = 'survey_services';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
