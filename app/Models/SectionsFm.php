<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionsFm extends Model
{
    protected $table = 'lpfm_sections';

    protected $guarded = [''];
    public function menu()
    {
        return $this->belongsTo(MasterMenu::class, 'menu_id');
    }

    public function contents()
    {
        return $this->hasMany(SectionContentsFm::class, 'section_id');
    }
}
