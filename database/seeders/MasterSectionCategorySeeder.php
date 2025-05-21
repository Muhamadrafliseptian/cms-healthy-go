<?php

namespace Database\Seeders;

use App\Models\MasterSectionCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterSectionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            'banner' => 'sb',
            'taghome1' => 'staghome1',
            'taghome2' => 'staghome2',
            'taghome3' => 'staghome3',
            'service' => 'ssservice',
            'program' => 'sprogram',
            'partnership' => 'spartnership',
            'testimoni' => 'stestimoni',
            'location' => 'slocation',
            'meal' => 'smeal',
            'promo' => 'spromo',
            'solution' => 'ssolution',
            'about' => 'sabout',
            'milestones' => 'smilestones',
            'contact' => 'scontact',
            'partnership2' => 'spartnership2',
            'partnership3' => 'spartnership3',
            'product' => 'sproduct',
            'carousel' => 'scarousel',
            'faq' => 'sfaq',
            'faq2' => 'sfaq2',
            'footer' => 'sfooter',
        ];

        foreach ($sections as $name => $slug) {
            MasterSectionCategory::create([
                'name' => ucfirst($name),
                'slug' => $slug,
            ]);
        }
    }
}
