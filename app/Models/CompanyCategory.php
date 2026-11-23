<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id_category';
    public $timestamps = false;
    protected $guarded = ['id_category'];
}
