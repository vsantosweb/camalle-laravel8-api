<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondentListsToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondent_lists_to_messages', function (Blueprint $table) {
            
            $table->unsignedBigInteger('respondent_list_id');
            $table->unsignedBigInteger('respondent_disc_message_id');
            
            $table->foreign('respondent_list_id')->references('id')->on('respondent_lists')->onDelete('cascade');
            $table->foreign('respondent_disc_message_id')->references('id')->on('respondent_disc_messages')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respondent_lists_to_messages');
    }
}
