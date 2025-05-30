<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'lpt_visitors';
    public $timestamps = false;
    protected $guarded = [''];
}
