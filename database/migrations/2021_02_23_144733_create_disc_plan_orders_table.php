<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscPlanOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_plan_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('disc_plan_id');
            $table->integer('quantity')->default(1);
            $table->double('price');
            $table->double('total');
            $table->double('tax')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('disc_plan_id')->references('id')->on('disc_plans');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_plan_orders');
    }
}
