<?php

use Illuminate\Database\Seeder;

class CombinationSubmenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subMenus = [
            [
                'title' => '50BB+',
                'menu_id' => 1
            ],
            [
                'title' => '40-50BB',
                'menu_id' => 1
            ],
            [
                'title' => '30-40BB',
                'menu_id' => 1
            ],
            [
                'title' => '20-30',
                'menu_id' => 1
            ],
            [
                'title' => '10-20BB',
                'menu_id' => 1
            ],
            [
                'title' => '50+',
                'menu_id' => 2
            ],
            [
                'title' => '40-50',
                'menu_id' => 2
            ],
            [
                'title' => '30-40',
                'menu_id' => 2
            ],
            [
                'title' => '20-30',
                'menu_id' => 2
            ],
            [
                'title' => '10-20BB',
                'menu_id' => 2
            ],
            [
                'title' => 'DEFENDIG',
                'menu_id' => 3
            ],
            [
                'title' => 'VS SB LIMP',
                'menu_id' => 3
            ],
            [
                'title' => 'VS LP',
                'menu_id' => 3
            ],
            [
                'title' => 'VS MP/HJ',
                'menu_id' => 3
            ],
            [
                'title' => 'VS EP OPEN MULTIWAY POT',
                'menu_id' => 3
            ],
            [
                'title' => 'VS LP OPEN MULIWAY POT',
                'menu_id' => 3
            ],
            [
                'title' => '20BB',
                'menu_id' => 4
            ],
            [
                'title' => '19BB',
                'menu_id' => 4
            ],
            [
                'title' => '18BB',
                'menu_id' => 4
            ],
            [
                'title' => '17BB',
                'menu_id' => 4
            ],
            [
                'title' => '16BB',
                'menu_id' => 4
            ],
            [
                'title' => '15BB',
                'menu_id' => 4
            ],
            [
                'title' => '14BB',
                'menu_id' => 4
            ],
            [
                'title' => '13BB',
                'menu_id' => 4
            ],
            [
                'title' => '12BB',
                'menu_id' => 4
            ],
            [
                'title' => '11BB',
                'menu_id' => 4
            ],
            [
                'title' => '10BB',
                'menu_id' => 4
            ],
            [
                'title' => '09BB',
                'menu_id' => 4
            ],
            [
                'title' => '08BB',
                'menu_id' => 4
            ],
            [
                'title' => '07BB',
                'menu_id' => 4
            ],
            [
                'title' => '06BB',
                'menu_id' => 4
            ],
            [
                'title' => 'UTG1',
                'menu_id' => 5
            ],
            [
                'title' => 'MP',
                'menu_id' => 5
            ],
            [
                'title' => 'MP1',
                'menu_id' => 5
            ],
            [
                'title' => 'HJ',
                'menu_id' => 5
            ],
            [
                'title' => 'CO',
                'menu_id' => 5
            ],
            [
                'title' => 'BTN',
                'menu_id' => 5
            ],
            [
                'title' => 'SB',
                'menu_id' => 5
            ],
            [
                'title' => 'BB',
                'menu_id' => 5
            ],
            [
                'title' => 'UTG',
                'menu_id' => 6
            ],
            [
                'title' => 'UTG1',
                'menu_id' => 6
            ],
            [
                'title' => 'MP',
                'menu_id' => 6
            ],
            [
                'title' => 'MP1',
                'menu_id' => 6
            ],
            [
                'title' => 'HJ',
                'menu_id' => 6
            ],
            [
                'title' => 'CO',
                'menu_id' => 6
            ],
            [
                'title' => 'BTN',
                'menu_id' => 6
            ],
            [
                'title' => 'SB',
                'menu_id' => 6
            ],
            [
                'title' => 'SB 25BB-',
                'menu_id' => 7
            ],
            [
                'title' => 'SB 25BB+',
                'menu_id' => 7
            ],
            [
                'title' => 'BB 25BB-',
                'menu_id' => 7
            ],
            [
                'title' => 'BB 25BB+',
                'menu_id' => 7
            ],
        ];

        \App\CombinationSubmenu::query()->insert($subMenus);
    }
}
