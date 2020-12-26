<?php

use Illuminate\Database\Migrations\Migration;

class SeedCombinationMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var CombinationMenusSeeder $seeder */
        $seeder = app(CombinationMenusSeeder::class);
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
