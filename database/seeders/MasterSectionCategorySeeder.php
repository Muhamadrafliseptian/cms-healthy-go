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
            'bfood' => 'sfood',
            'sabout' => 'sabout1',
            'bpartnership' => 'bpartnership',
            'partnership1' => 'spartnership1',
            'partnership2' => 'spartnership2',
            'partnership3' => 'spartnership3',
            'partnership4' => 'spartnership4',
            'service' => 'ssservice',
            'service1' => 'ssservice1',
            'program' => 'sprogram',
            'partnership' => 'spartnership',
            'testimoni' => 'stestimoni',
            'location' => 'slocation',
            'meal' => 'smeal',
            'promo' => 'spromo',
            'solution' => 'ssolution',
            'milestones' => 'smilestones',
            'contact' => 'scontact',
            'product' => 'sproduct',
            'product1' => 'sproduc1',
            'product2' => 'sproduct2',
            'product3' => 'sproduct3',
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
