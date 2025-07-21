<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionContentsFm extends Model
{
    public function section()
    {
        return $this->belongsTo(SectionsFm::class, 'section_id');
    }
}
