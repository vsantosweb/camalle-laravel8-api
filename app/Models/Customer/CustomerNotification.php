<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerNotification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'customer_id', 'title', 'type', 'tyle','data' , 'read_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
