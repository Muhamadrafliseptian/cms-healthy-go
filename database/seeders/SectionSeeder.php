<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SectionContent;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SectionContent::insert([
            [
                'id' => 1,
                'menu_id' => 10,
                'section' => 'spartnership4',
                'title' => 'Partnership',
                'subtitle1' => '<p>Partner yang telah bekerja sama dengan kami</p>',
                'subtitle2' => '<p>Kami telah bekerja sama dengan individu dan brand terpercaya yang memiliki dedikasi tinggi terhadap gaya hidup sehat.</p>',
                'created_at' => '2025-05-23 00:50:33',
                'updated_at' => '2025-05-25 11:15:50',
            ],
            [
                'id' => 2,
                'menu_id' => 23,
                'section' => 'sproduc1',
                'title' => '<p>ada</p>',
                'subtitle1' => '<p>ada</p>',
                'created_at' => '2025-05-23 01:39:23',
                'updated_at' => '2025-05-23 01:39:23',
            ],
            [
                'id' => 3,
                'menu_id' => 24,
                'section' => 'sproduct2',
                'title' => '<p>adass</p>',
                'subtitle1' => '<p>adass</p>',
                'created_at' => '2025-05-23 01:40:19',
                'updated_at' => '2025-05-23 01:40:25',
            ],
            [
                'id' => 4,
                'menu_id' => 24,
                'section' => 'shome1',
                'title' => '<p>adass</p>',
                'subtitle1' => '<p>adass</p>',
                'created_at' => '2025-05-23 01:40:19',
                'updated_at' => '2025-05-23 01:40:25',
            ],
        ]);
    }
}
