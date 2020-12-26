<?php

use App\Enums\PayPalPaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('plan_id')->unsigned();
            $table->string('transaction_id');
            $table->enum('transaction_status', PayPalPaymentStatus::toArray())->default(PayPalPaymentStatus::CREATED);
            $table->string('transaction_payer')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->float('price_paid');
            $table->dateTime('expire_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_user');
    }
}
