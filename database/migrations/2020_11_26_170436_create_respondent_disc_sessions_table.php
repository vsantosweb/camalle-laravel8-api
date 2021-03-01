<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondentDiscSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondent_disc_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100);
            $table->string('token', 100)->unique();
            $table->string('session_url')->nullable();
            $table->text('session_data')->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->tinyInteger('was_finished')->default(0)->comment('0 false | 1 true');
            $table->tinyInteger('active')->default(0)->comment('0 false | 1 true');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('geolocation')->nullable();
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
        Schema::dropIfExists('respondent_disc_sessions');
    }
}
