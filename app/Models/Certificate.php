<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = "lpt_certificate";

    protected $guarded = [''];

    public $timestamps = false;
}
