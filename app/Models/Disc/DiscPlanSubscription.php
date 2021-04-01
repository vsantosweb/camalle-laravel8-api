<?php

namespace App\Models\Disc;

use App\Models\Customer\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscPlanSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_id',
        'status',
        'amount',
        'validity_days',
        'expire_at',
        'credits',
    ];

    protected $casts = ['features' => 'object'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan()
    {
        return $this->belongsTo(DiscPlan::class, 'disc_plan_id')->with('periods');
    }

    public function invoices()
    {
        return $this->hasMany(DiscPlanSubscriptionInvoice::class, 'plan_subscription_id');
    }

    public function checkCreditAvaiable($respondentcount)
    {

        if ($this->credits >= $respondentcount) {
            return true;
        }
        throw new \Exception('Insufficient credit balance', 1);
    }

    public static function closeInvoices()
    {

        $subscriptions = self::where('expire_at', '>', now())->get();

        foreach ($subscriptions as $subscription) {

            $subscription->update(['status' => 2]);

            $expirationDate = Carbon::createFromDate($subscription->expire_at);

            $subscriptionCicle = Carbon::createFromDate($subscription->expire_at)->format('d-m-y');
            $invoiceExpireAt = Carbon::createFromDate($subscription->expire_at)->addDays(10)->format('d-m-y');
            $invoiceCloseAt = Carbon::createFromDate($subscription->expire_at)->addDays(-5)->format('d-m-y');

            return dd([

                'ciclo' => $subscriptionCicle,
                'fechamento_fatura' => $invoiceCloseAt,
                'vencimento_fatura' => $invoiceExpireAt,

            ]);

            return [$expirationDate->addDays(-5)->diffInDays($subscription->expire_at), $subscription->expire_at];
        }
    }

    public function dispatchCreditConsummation($respondents)
    {
        
        $this->credits -= count($respondents);
        $this->total_usage += count($respondents);
        $this->save();
    }

    public function consumationDetails()
    {
        $currentCredits =  $this->credits;
        $planCredits = $this->plan->features->credits;

        return [
            'plan_name' => $this->plan->name,
            'plan_credits' => $planCredits,
            'current_credits' => $currentCredits,
            'usage_percent' => $currentCredits / $planCredits * 100,
            'total_usage' => $this->total_usage,
            'additionals_credits' => $this->additionals_credits,
            'expire_at' => $this->expire_at
        ];
    }
}
