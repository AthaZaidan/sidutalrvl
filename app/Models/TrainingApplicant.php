<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingApplicant extends Model
{
    protected $table = 'list_applicanttr';
    protected $primaryKey = 'id_listapplicant';
    public $timestamps = false;
    protected $guarded = ['id_listapplicant'];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id_training');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
