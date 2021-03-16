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
            $table->uuid('code', 60)->unique();
            $table->unsignedBigInteger('customer_id');
            $table->string('respondent_name');
            $table->string('respondent_email');
            $table->string('message_uuid');
            $table->string('category')->nullable();
            $table->string('profile')->nullable();
            $table->text('metadata')->nullable();
            $table->tinyInteger('was_finished')->default(0)->comment('0 Não finalizado | 1 finalizado');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('geolocation')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

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
