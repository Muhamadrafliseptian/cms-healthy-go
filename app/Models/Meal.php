<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $table = "lpt_meal";

    protected $guarded = [''];

    public $timestamps = false;
}
