<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputeCategory extends Model
{
    protected $table = 'list_dispute_category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
