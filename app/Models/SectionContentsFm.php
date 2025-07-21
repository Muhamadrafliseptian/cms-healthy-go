<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionContentsFm extends Model
{
    protected $table = 'lpfm_section_contents';

    protected $guarded  = [''];

    public function section()
    {
        return $this->belongsTo(SectionsFm::class, 'section_id');
    }
}
