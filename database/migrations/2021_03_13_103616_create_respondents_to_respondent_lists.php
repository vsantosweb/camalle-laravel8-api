<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondentsToRespondentLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondents_to_respondent_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('respondent_list_id');
            $table->unsignedBigInteger('respondent_id');

            $table->foreign('respondent_list_id')->references('id')->on('respondent_lists')->onDelete('cascade');
            $table->foreign('respondent_id')->references('id')->on('respondents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respondents_to_respondent_lists');
    }
}
