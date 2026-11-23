<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    protected $table = 'user_menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function subMenus()
    {
        return $this->hasMany(UserSubMenu::class, 'menu_id', 'id');
    }
}
