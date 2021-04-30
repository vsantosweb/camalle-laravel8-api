<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscPlanSubscriptionInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'plan_subscription_id',
        'status',
        'amount',
        'expire_at',
        'closed_at',
        'cicle',
    ];

    public function subscription()
    {
        return $this->belongsTo(DiscPlanSubscription::class);
    }
}
