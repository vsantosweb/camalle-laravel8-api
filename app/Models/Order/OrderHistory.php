<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    
    protected $fillable = ['order_id', 'order_data'];
    
    protected $table = 'order_history';
    protected $casts = ['order_data' => 'object'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
