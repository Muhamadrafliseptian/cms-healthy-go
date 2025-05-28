<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMeta extends Model
{
    protected $table = 'lptm_meta';

    protected $guarded = [''];

    public function menu()
    {
        return $this->belongsTo(MasterMenu::class, 'menu_id');
    }
}
