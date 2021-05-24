<?php

namespace App\Http\Controllers\Api\v1\Client\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerType;
use App\Models\Disc\DiscPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerRegisterController extends Controller
{
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function customerTypes()
    {
        return $this->outputJSON(CustomerType::all(), '', false);
    }
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|unique:customers',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->outputJSON($validator->errors(), '', true, 200);
        }

        $newCustomer =  $this->customer->create([
            'uuid' => Str::uuid(),
            'customer_type_id' => request()->customer_type,
            'name' => ucwords(strtolower(request()->name)),
            'email' => strtolower(request()->email),
            'accepted_terms' => request()->accepted_terms,
            'notify' => isset(request()->notify) ?  request()->notify : 0,
            'password' => Hash::make(request()->password)
        ]);

        $order = $newCustomer->orders()->create([
            'code' => strtoupper(uniqid()),
            'order_status_id' => 1,
            'status' => 'APPROVED',
            'payment_method' => 'FREE_MODE',
            'type' => 'PLAN_SUBSCRIPTION',
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip(),
            'total' => 0,
        ]);

        $discPlan = DiscPlan::where('joing_free', 1)->first();

        $discPlan->order()->create([
            'order_id' => $order->id,
            'price' => $discPlan->price,
            'total' => 0,
            'tax' => 0,
        ]);

        $subscription = $discPlan->subscriptions()->create([
            'code' => strtoupper(Str::random(15)),
            'customer_id' => $newCustomer->id,
            'status' => 1,
            'credits' => $discPlan->features->credits,
            'amount' => $discPlan->price,
            'validity_days' => $discPlan->periods()->find(1)->validity_days,
            'expire_at' => now()->addDays(30),
        ]);

        $subscription->invoices()->create([
            'code' => strtoupper(uniqid()),
            // 'plan_subscription_id' => $subscription->id,
            'status' => 'PAID',
            'amount' => $subscription->amount,
            'expire_at' => now()->addDays($subscription->validity_days),
        ]);


        return $this->outputJSON('', $newCustomer->sendMailVerification(), false, 201);
    }
}
