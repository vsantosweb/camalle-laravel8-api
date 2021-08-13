<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'customer_id',
        'address_1',
        'address_2',
        'number',
        'complement',
        'zipcode',
        'city',
        'state',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
