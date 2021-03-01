<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscPlanSubscriptionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disc_plan_subscription_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 60);
            $table->unsignedBigInteger('plan_subscription_id');
            $table->string('status');
            $table->double('amount');
            $table->timestamp('expire_at');
            $table->timestamps();

            $table->foreign('plan_subscription_id')->references('id')->on('disc_plan_subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disc_plan_subscription_invoices');
    }
}
