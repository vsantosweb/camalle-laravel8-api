<?php

namespace App\Models\Disc;

use App\Models\Customer\Customer;
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

    public function checkCreditAvaiable()
    {
        return $this->credits > 0 ? true : false;
    }

    public function dispatchCreditConsummation($respondents)
    {
        $this->credits -= count($respondents);
        $this->total_usage += count($respondents);
        $this->save();
    }
}
