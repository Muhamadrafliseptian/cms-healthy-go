<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionContent extends Model
{
    use HasFactory;

    protected $table = 'lpt_section_content';

    protected $fillable = [
        'menu_id',
        'section',
        'title',
        'subtitle1',
        'subtitle2',
        'subtitle3',
        'subtitle4',
        'subtitle5',
        'img',
        'img2',
    ];

    public function menu()
    {
        return $this->belongsTo(MasterSectionCategory::class, 'menu_id');
    }
}
