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
            'bhome' => 'sbhome',
            'shome' => 'shome1',
            'babout' => 'sabout',
            'sabout' => 'sabout1',
            'service' => 'ssservice',
            'program' => 'sprogram',
            'partnership' => 'spartnership',
            'testimoni' => 'stestimoni',
            'location' => 'slocation',
            'meal' => 'smeal',
            'promo' => 'spromo',
            'solution' => 'ssolution',
            'milestones' => 'smilestones',
            'contact' => 'scontact',
            'partnership2' => 'spartnership2',
            'partnership3' => 'spartnership3',
            'product' => 'sproduct',
            'carousel' => 'scarousel',
            'faq' => 'sfaq',
            'faq2' => 'sfaq2',
            'footer' => 'sfooter',
            'iachievement' => 'isachievement',
            'ibanner' => 'isbanner',
            'ipromo' => 'ispromo',
            'ipromo1' => 'ispromo1',
            'igoals' => 'isigoals',
            'statistic' => 'sstatistic',
        ];

        foreach ($sections as $name => $slug) {
            MasterSectionCategory::create([
                'name' => ucfirst($name),
                'slug' => $slug,
            ]);
        }
    }
}
