<?php

namespace App\Models\Disc;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscPlanOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'disc_plan_id',
        'quantity',
        'price',
        'total',
        'tax',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class)->with('plan', 'status');
    }

    public function plan()
    {
        return $this->belongsTo(DiscPlan::class, 'disc_plan_id');
    }
}
