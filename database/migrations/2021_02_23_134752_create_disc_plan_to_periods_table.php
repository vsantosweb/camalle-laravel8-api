<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscPlanToPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_plan_to_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disc_plan_id');
            $table->unsignedBigInteger('disc_plan_period_id');
            $table->boolean('showcase')->default(false);
            $table->double('discount')->default(0);
            $table->timestamps();

            $table->foreign('disc_plan_id')->references('id')->on('disc_plans')->onDelete('cascade');
            $table->foreign('disc_plan_period_id')->references('id')->on('disc_plan_periods')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_plan_to_periods');
    }
}
