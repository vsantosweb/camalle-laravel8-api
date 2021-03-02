<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DiscSeeder::class,
            CustomerTypeSeeder::class,
            CustomerSeeder::class,
            DiscSegmentSeeder::class,
            DiscGraphTypesSeeder::class,
            DiscRangeSeeder::class,
            RespondentListSeeder::class,
            // RespondentSeeder::class,
            DiscPlanSeeder::class,
            DiscPlanPeriodSeeder::class,
            DiscPlanSubscriptionSeeder::class,
            DiscPlanSubscriptionInvoice::class,
            OrderStatusSeeder::class,
            OrderSeeder::class,
            DiscPlanOrder::class,
            RespondentDiscMessages::class
            // DiscProfileSeeder::class,
            // DiscCategorySeeder::class

        ]);
    }
}
