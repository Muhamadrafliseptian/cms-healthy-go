<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $table = "lpt_batch_menu";

    protected $guarded = [''];

    public $timestamps = false;

    public function batch(): BelongsTo
    {
        return $this->belongsTo(MasterBatch::class);
    }
}
