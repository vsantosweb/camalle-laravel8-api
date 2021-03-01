<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscCombinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_combinations', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->unsignedBigInteger('disc_profile_id');
            $table->unsignedBigInteger('disc_category_id');
            $table->timestamps();

            $table->foreign('disc_profile_id')->references('id')->on('disc_profiles');
            $table->foreign('disc_category_id')->references('id')->on('disc_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_combinations');
    }
}
