<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table = 'faq_category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
