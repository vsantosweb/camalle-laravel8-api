<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscIntensitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_intensities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disc_id');
            $table->integer('number');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('disc_id')->references('id')->on('disc')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_intensities');
    }
}
