<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerSubscriptionController extends Controller
{

    public function showSubscription()
    {
        return $this->outputJSON(auth()->user()->subscription, '', false);
    }

    public function consumation()
    {
        return $this->outputJSON(auth()->user()->subscription->consumationDetails(), '', false);
    }
}
