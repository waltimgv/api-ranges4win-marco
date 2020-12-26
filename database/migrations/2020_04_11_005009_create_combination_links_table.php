<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinationLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combination_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('submenu_id');
            $table->string('title', 120);
            $table->foreign('submenu_id')->references('id')->on('combination_submenus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('combination_links');
    }
}
