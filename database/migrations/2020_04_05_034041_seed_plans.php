<?php

use Illuminate\Database\Migrations\Migration;

class SeedPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var PlansSeeder $seeder */
        $seeder = app(PlansSeeder::class);
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
