<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            
            $table->id();
            $table->string('code', 60)->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_status_id');
            $table->string('status')->nullable();
            $table->string('payment_method');
            $table->string('type')->nullable();
            $table->double('total');
            $table->string('user_agent')->nullable();
            $table->string('ip')->nullable();
            $table->string('geolocation')->nullable();
            $table->timestamps();

            $table->foreign('order_status_id')->references('id')->on('order_status');
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
        Schema::dropIfExists('orders');
    }
}
