<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyRespondenAnswer extends Model
{
    protected $table = 'survey_responden_answers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id', 'id');
    }
}
