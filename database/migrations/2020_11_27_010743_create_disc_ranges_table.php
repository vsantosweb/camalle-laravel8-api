<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_ranges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disc_graph_type_id');
            $table->unsignedBigInteger('disc_id');
            $table->text('range')->nullable();
            $table->unsignedBigInteger('segment_id');
            $table->timestamps();


            $table->foreign('disc_graph_type_id')->references('id')->on('disc_graph_types')->onDelete('cascade');
            $table->foreign('disc_id')->references('id')->on('disc');
            $table->foreign('segment_id')->references('id')->on('disc_segments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_ranges');
    }
}
