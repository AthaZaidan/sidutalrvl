<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubtypeNotification extends Model
{
    protected $table = 'subtypelist_notification';
    protected $primaryKey = 'id_listsubtype';
    public $timestamps = false;
    protected $guarded = ['id_listsubtype'];
}
