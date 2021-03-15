<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondentListImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondent_list_imports', function (Blueprint $table) {
            
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('respondent_list_id');
            $table->string('name')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->integer('total_items')->nullable();
            $table->integer('created_items')->nullable();
            $table->tinyInteger('status')->comment('0 Não importado | 1 Finalizado | 2 Pendente | 3 Falha ')->default(2);
            $table->longText('log')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('respondent_list_id')->references('id')->on('respondent_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respondent_list_imports');
    }
}
