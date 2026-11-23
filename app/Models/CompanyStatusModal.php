<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyStatusModal extends Model
{
    protected $table = 'company_status_modal';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}
