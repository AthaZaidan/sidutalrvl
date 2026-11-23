<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_role';
    protected $primaryKey = 'id_role';
    public $timestamps = false;
    protected $guarded = ['id_role'];

    public function menus()
    {
        return $this->belongsToMany(UserMenu::class, 'user_access_menu', 'role_id', 'menu_id');
    }
}
