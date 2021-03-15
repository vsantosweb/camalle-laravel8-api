<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('customer_type_id');
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('document_1')->nullable();
            $table->string('document_2')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_document')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->default(1);
            $table->string('notify')->default(0);
            $table->string('newsletter')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->string('home_dir')->nullable();
            $table->tinyInteger('first_access')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_type_id')->references('id')->on('customer_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
