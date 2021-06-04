<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Disc\Plan;

use App\Events\Customer\CustomerNotificationEvent;
use App\Events\Notification\SendNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Disc\DiscPlan;
use App\Models\Disc\DiscPlanSubscription;
use App\Notifications\CustomerCreditAdditionalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class DiscPlanSubscriptionController extends Controller
{

    public function __construct(DiscPlanSubscription $discPlanSubscription)
    {

        $this->discPlanSubscription = $discPlanSubscription;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->discPlanSubscription->with(['customer' => function ($query) {
            $query->select('id', 'name', 'company_name');
        }])->get();

        return $this->outputJSON($customers, '', false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $discPlan = DiscPlan::where('code', $request->disc_plan_code)->first();
        $customer = Customer::where('uuid', $request->customer_id)->first();
        $subscription = DiscPlanSubscription::where('customer_id', $customer->id)->where('disc_plan_id', $discPlan->id)->first();

        if ($subscription) return $this->outputJSON([], 'customer already has a subscription', true, 400);


        try {

            $order = $customer->orders()->create([
                'code' => strtoupper(uniqid()),
                'order_status_id' => 1,
                'status' => 'APPROVED',
                'payment_method' => 'FREE_MODE',
                'type' => 'PLAN_SUBSCRIPTION',
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
                'total' => 0,
            ]);

            $discPlan->order()->create([
                'order_id' => $order->id,
                'price' => $discPlan->price,
                'total' => 0,
                'tax' => 0,
            ]);

            $subscription = $discPlan->subscriptions()->create([
                'code' => strtoupper(Str::random(15)),
                'customer_id' => $customer->id,
                'status' => 1,
                'credits' => $discPlan->features->credits,
                'amount' => $discPlan->price,
                'validity_days' => $discPlan->periods()->find($request->period_id)->validity_days,
                'expire_at' => now()->addDays($discPlan->periods()->find($request->period_id)->validity_days),
            ]);

            $subscription->invoices()->create([
                'code' => strtoupper(uniqid()),
                'plan_subscription_id' => $subscription->id,
                'status' => 'PAID',
                'amount' => $subscription->amount,
                'expire_at' => now()->addDays($subscription->validity_days),
            ]);

            return $this->outputJSON($subscription->with('plan')->find($subscription->id), 'Success', false, 201);
        } catch (\Throwable $th) {

            return $this->outputJSON([], $th->getMessage(), true, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function storeAdditionalsCredits()
    {

        $customer = Customer::where('uuid', request()->customer_id)->first();

        $order = $customer->orders()->create([
            'code' => strtoupper(uniqid()),
            'order_status_id' => 1,
            'status' => 'APPROVED',
            'payment_method' => request()->payment_method,
            'type' => 'ADDITIONAL_CREDITS',
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip(),
            'total' => request()->total_amount,
        ]);

        $order->history()->create([
            'order_data' => request()->all()
        ]);

        $currentAdditionalCredits = $customer->subscription->additionals_credits;

        $customer->subscription->update([
            'additionals_credits' => $currentAdditionalCredits + request()->additionals_credits
        ]);

        $currentInvoiceAmount = $customer->subscription->invoices->last()->amount;

        $customer->subscription->invoices->last()->update([
            'code' => strtoupper(uniqid()),
            'status' => 'PAID',
            'amount' =>  $currentInvoiceAmount + request()->total_amount,
            'expire_at' => now()->addDays($customer->subscription->validity_days),
        ]);
        
        $customer->notifications()->create([

            'type' => 'notify',
            'title' => 'Créditos Adicionais',
            'data' => 'Foram adicionados' . request()->additionals_credits . ' em sua conta.',

        ]);
        
        event(new CustomerNotificationEvent($customer->notifications()->where('read_at', NULL)->get(), $customer));
        // $customer->notify(new CustomerCreditAdditionalNotification($order));
        
        return $this->outputJSON($customer->subscription, '', false, 200);
    }

    public function additionalCreditOrderHistory($customer_id)
    {

        $customer = Customer::where('uuid', $customer_id)->first();

        $additionalCreditOrders = $customer->orders()->with('history')->orderBy('created_at', 'DESC')->where('type', 'ADDITIONAL_CREDITS')->get();

        return $this->outputJSON($additionalCreditOrders, '', false, 200);
    }
}
