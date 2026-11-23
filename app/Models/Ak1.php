<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ak1 extends Model
{
    protected $table = 'ak1';
    protected $primaryKey = 'id_ak1';
    public $timestamps = false;
    protected $guarded = ['id_ak1'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function desiredJob()
    {
        return $this->hasOne(UserDesiredJob::class, 'id_ak1', 'id_ak1')->where('deleted', 0);
    }
}
