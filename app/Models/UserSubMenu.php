<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubMenu extends Model
{
    protected $table = 'user_sub_menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(UserMenu::class, 'menu_id', 'id');
    }
}
