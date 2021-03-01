<?php

namespace Database\Seeders;

use App\Models\Disc\DiscPlanSubscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscPlanSubscriptionInvoice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_plan_subscription_invoices')->insert([
            'code' => strtoupper(uniqid()),
            'plan_subscription_id' => 1,
            'status' => 'PAID',
            'amount' => DiscPlanSubscription::find(1)->amount,
            'expire_at' => now()->addDays(DiscPlanSubscription::find(1)->validity_days),
        ]);
    }
}
