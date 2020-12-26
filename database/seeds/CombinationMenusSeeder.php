<?php

use Illuminate\Database\Seeder;

class CombinationMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\CombinationMenu::query()->insert([
            ['title' => 'OPEN RAISE'],
            ['title' => 'FLAT & 3BET'],
            ['title' => 'BIG BLIND'],
            ['title' => 'JAMMING'],
            ['title' => 'REJAMMING'],
            ['title' => 'CALLING REJAM'],
            ['title' => 'HEADS UP'],
        ]);
    }
}
