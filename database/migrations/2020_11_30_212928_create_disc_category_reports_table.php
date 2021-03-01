<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscCategoryReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_category_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disc_category_id');
            $table->string('name');
            $table->string('slug');
            $table->text('metadata')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('disc_category_reports');
    }
}
