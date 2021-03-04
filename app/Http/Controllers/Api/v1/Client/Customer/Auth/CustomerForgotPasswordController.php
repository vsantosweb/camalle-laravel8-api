<?php

namespace App\Http\Controllers\Api\v1\Client\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Notifications\SendResetEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CustomerForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function forget()
    {
        $credentials = request()->validate(['email' => 'required|email']);

        $customer = Customer::where('email',  $credentials)->firstOrfail();

        $tokenData = DB::table('password_resets')->where('email', request()->email)->first();

        if(empty($tokenData)) {

            DB::table('password_resets')->insert([
                'email' => $customer->email,
                'token' => Str::random(60),
                'created_at' => now()
            ]);
        }
        
        $tokenData = DB::table('password_resets')->where('email', request()->email)->first();
        $link = env('APP_URL_PASSWORD_RESET'). DIRECTORY_SEPARATOR .'?token='. $tokenData->token . '&email=' . $tokenData->email;
        $customer->notify(new SendResetEmailNotification($customer, $link));

        return $this->outputJSON('Reset password link sent on your email id.', [], false, 201);
    }
}
