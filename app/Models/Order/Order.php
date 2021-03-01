<?php

namespace App\Models\Order;

use App\Models\Customer\Customer;
use App\Models\Disc\DiscPlanOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        'code',
        'customer_id',
        'order_status_id',
        'payment_method',
        'type',
        'total',
        'user_agent',
        'ip',
        'status',
        'geolocation',
    ];
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function discPlanOrder(){

        return $this->hasOne(DiscPlanOrder::class)->with('plan');
    }
}
