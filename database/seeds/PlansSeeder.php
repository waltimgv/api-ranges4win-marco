<?php

use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Plan::query()->insert([
            [
                'number_days' => 30,
                'description' => 'Descrição do plano de 30 dias',
                'price' => 15.99,
            ],
            [
                'number_days' => 365,
                'description' => 'Descrição do plano de 365 dias',
                'price' => 180.99,
            ],
        ]);
    }
}
