<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTkdn extends Model
{
    protected $table = 'report_tkdn';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
