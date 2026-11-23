<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipApplicant extends Model
{
    protected $table = 'list_applicantin';
    protected $primaryKey = 'id_listapplicant';
    public $timestamps = false;
    protected $guarded = ['id_listapplicant'];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'intern_id', 'id_intern');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
