<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_question_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('disc_question_id');
            $table->string('description');
            $table->string('less');
            $table->string('more');
            $table->timestamps();

            $table->foreign('disc_question_id')->references('id')->on('disc_questions')->onDelete('cascade');
            // $table->foreign('less')->references('id')->on('disc')->onDelete('cascade');
            // $table->foreign('more')->references('id')->on('disc')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_question_options');
    }
}
