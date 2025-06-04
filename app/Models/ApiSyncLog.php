<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiSyncLog extends Model
{
    protected $table = 'lpt_api_sync_batch_logs';
    protected $guarded = [''];
    public $timestamps = true;
}
