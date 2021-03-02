<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscPlanSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 60)->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('disc_plan_id');
            $table->integer('credits')->default(0);
            $table->integer('additionals_credits')->default(0);
            $table->integer('total_usage')->default(0);
            $table->tinyInteger('status');
            $table->double('amount');
            $table->integer('validity_days');
            $table->timestamp('expire_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('disc_plan_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('disc_plan_subscriptions');
    }
}
