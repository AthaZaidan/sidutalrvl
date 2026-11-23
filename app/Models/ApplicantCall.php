<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantCall extends Model
{
    protected $table = 'applicant_call';
    protected $primaryKey = 'id_call';
    public $timestamps = false;
    protected $guarded = ['id_call'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
