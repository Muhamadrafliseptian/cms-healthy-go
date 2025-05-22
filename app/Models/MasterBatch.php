<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBatch extends Model
{
    protected $table = 'lptm_batch';

    protected $guarded = [''];

    public function batchMenu(){
        return $this->hasMany(Menu::class);
    }
}
