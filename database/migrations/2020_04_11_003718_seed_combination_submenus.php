<?php

use Illuminate\Database\Migrations\Migration;

class SeedCombinationSubmenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var CombinationSubmenusSeeder $seeder */
        $seeder = app(CombinationSubmenusSeeder::class);
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
