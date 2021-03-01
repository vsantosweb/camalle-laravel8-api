<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name' ,'slug'];
    protected $table = 'order_status';

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
