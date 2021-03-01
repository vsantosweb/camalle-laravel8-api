<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondentDiscTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondent_disc_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('respondent_id');
            $table->unsignedBigInteger('respondent_disc_test_message_id');
            $table->uuid('code', 60)->unique();
            $table->text('metadata')->nullable();
            $table->tinyInteger('was_finished')->default(0)->comment('0 Não finalizado | 1 finalizado');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('geolocation')->nullable();
            $table->timestamps();

            $table->foreign('respondent_id')->references('id')->on('respondents')->onDelete('cascade');
            $table->foreign('respondent_disc_test_message_id')->references('id')->on('respondent_disc_messages');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respondent_disc_tests');
    }
}
