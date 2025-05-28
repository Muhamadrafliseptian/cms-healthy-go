<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMenu extends Model
{
    protected $table = 'lptm_menu';

    public function meta()
    {
        return $this->hasOne(MasterMeta::class, 'master_menu_id');
    }
}
