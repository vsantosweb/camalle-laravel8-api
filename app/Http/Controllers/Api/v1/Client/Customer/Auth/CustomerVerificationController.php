<?php

namespace App\Http\Controllers\Api\v1\Client\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerVerificationController extends Controller
{
    public function verify()
    {
        $emailToken = DB::table('email_verifications')->where('email', request()->email)->where('token', request()->token);

        if (!$verifyData = $emailToken->first()) return $this->outputJSON([], 'Invalid token', true, 400);

        if (Hash::check($verifyData->email . env('APP_KEY'), $verifyData->signature)) {

            try {

                $customer = Customer::where('email', $verifyData->email)->first();
                $customer->update(['email_verified_at' => now()]);

                $emailToken->delete();

               return $this->outputJSON(JWTAuth::fromUser($customer), 'Email verified successfully', false);
           
            } catch (\Exception $e) {

                return $this->outputJSON([],  $e->getMessage(), true);
            }
        }
    }

    public function resend()
    {
    }
}
