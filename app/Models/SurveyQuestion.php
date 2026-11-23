<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_questions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
