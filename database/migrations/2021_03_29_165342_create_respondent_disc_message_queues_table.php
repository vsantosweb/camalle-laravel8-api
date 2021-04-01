<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondentDiscMessageQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondent_disc_message_queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('respondent_disc_message_id');
            $table->string('description');
            $table->boolean('run')->default(false);
            $table->text('metadata')->nullable();
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
        Schema::dropIfExists('respondent_disc_message_queues');
    }
}
