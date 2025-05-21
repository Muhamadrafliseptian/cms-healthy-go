<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterSectionCategory extends Model
{
    use HasFactory;

    protected $table = 'lptm_section_category';

    protected $guarded = [''];

    public function sections()
    {
        return $this->hasMany(SectionContent::class, 'menu_id');
    }
}
