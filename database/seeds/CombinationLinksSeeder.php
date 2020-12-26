<?php

use Illuminate\Database\Seeder;

class CombinationLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'title' => ['UTG'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]
            ],
            [
                'title' => ['UTG1'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40]
            ],
            [
                'title' => ['MP'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40, 41]
            ],
            [
                'title' => ['MP1'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40, 41, 42]
            ],
            [
                'title' => ['HJ'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40, 41, 42, 43]
            ],
            [
                'title' => ['CO'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40, 41, 42, 43, 44]
            ],
            [
                'title' => ['BTN'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40, 41, 42, 43, 44, 45]
            ],
            [
                'title' => ['SB'],
                'submenus' => [1, 2, 3, 4, 5, 11, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 40, 41, 42, 43, 44, 45, 46]
            ],
            [
                'title' => ['BB'],
                'submenus' => [40, 41, 42, 43, 44, 45, 46, 47]
            ],
            [
                'title' => ['>UTG', '>UTG1'],
                'submenus' => [33, 34, 35, 36, 37, 38, 39]
            ],
            [
                'title' => ['>MP'],
                'submenus' => [34, 35, 36, 37, 38, 39]
            ],
            [
                'title' => ['>MP1'],
                'submenus' => [35, 36, 37, 38, 39]
            ],
            [
                'title' => ['>HJ'],
                'submenus' => [36, 37, 38, 39]
            ],
            [
                'title' => ['2X', '2.5X', '3X'],
                'submenus' => [13, 14, 15, 16]
            ],
            [
                'title' => [
                    'UTG1 X UTG',
                    'MP X UTG',
                    'MP1 x UTG',
                    'HJ x UTG',
                    'CO x UTG',
                    'BTN x UTG',
                    'SB x UTG',
                    'BB X UTG',
                    'MP x UTG1',
                    'MP1 x UTG1',
                    'HJ x UTG1',
                    'CO x UTG1',
                    'BTN x UTG1',
                    'SB x UTG1',
                    'BB X UTG1',
                    'MP1 X MP',
                    'HJ x MP',
                    'CO X MP',
                    'BTN X MP',
                    'SB X MP',
                    'BB X MP',
                    'HJ X MP1',
                    'CO X MP1',
                    'BTN X MP1',
                    'SB X MP1',
                    'BB X MP1',
                    'CO X HJ',
                    'BTN X HJ',
                    'SB X HJ',
                    'BB X HJ',
                    'BTN X CO',
                    'SB X CO',
                    'BB X CO',
                    'SB X BTN',
                    'BB X BTN',
                    'BB X SB',
                ],
                'submenus' => [6, 7, 8, 9, 10]
            ],
            [
                'title' => ['25-30bb'],
                'submenus' => [12, 49, 51]
            ],
            [
                'title' => ['>CO'],
                'submenus' => [37, 38, 39]
            ],
            [
                'title' => ['>BTN'],
                'submenus' => [38, 39]
            ],
            [
                'title' => [
                    '30-35BB',
                    '35-40BB',
                    '40BB+'
                ],
                'submenus' => [49, 51]
            ],
            [
                'title' => [
                    '15-20bb',
                    '20-25bb',
                    '30bb+'
                ],
                'submenus' => [12]
            ],
            [
                'title' => ['> UTG'],
                'submenus' => [32]
            ],
            [
                'title' => ['>SB'],
                'submenus' => [39]
            ],
            [
                'title' => [
                    '8-10 LIMP SHOVE',
                    '10-15 LIMP SHOVE',
                    '15 -20 LIMP SHOVE',
                    'POR/LIMP 20-25BB',
                    'EXPLOIT VS FISH 20-25BB',
                ],
                'submenus' => [48]
            ],
            [
                'title' => [
                    '10-15BB RAISE',
                    '10-15BB LIMP',
                    '15-20BB RAISE',
                    '15-20BB LIMP',
                    '20-25BB RAISE',
                    '20-25BB LIMP'
                ],
                'submenus' => [50]
            ],
            [
                'title' => ['40BB+ VS FISH'],
                'submenus' => [51]
            ],
        ];

        collect($links)->each(function ($link) {
            $submenus = collect($link['submenus']);

            collect($link['title'])->each(function ($title) use ($submenus) {
                $submenus->each(function ($submenu) use ($title) {
                    \App\CombinationLink::query()->create([
                        'title' => $title,
                        'submenu_id' => $submenu
                    ]);
                });
            });
        });
    }
}
