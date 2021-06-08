<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;

    protected $fillable = [ 'customer_id', 'title', 'type', 'tyle','data' , 'read_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
