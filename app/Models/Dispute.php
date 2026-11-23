<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $table = 'dispute';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function mediatorUser()
    {
        return $this->belongsTo(User::class, 'mediator', 'id');
    }

    public function logs()
    {
        return $this->hasMany(DisputeLog::class, 'id_dispute', 'id')->orderBy('created');
    }
}
