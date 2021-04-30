<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Services\PagarmeService;
use Illuminate\Http\Request;

class CustomerSubscriptionController extends Controller
{

    public function showSubscription()
    {   
        $pagarme = PagarmeService::start();

        return $pagarme->subscriptions()->getList();

        return $this->outputJSON(auth()->user()->subscription, '', false);
    }

    public function consumation()
    {
        return $this->outputJSON(auth()->user()->subscription->consumationDetails(), '', false);
    }
}
