<?php

namespace App\Http\Controllers\Api\v1\Client\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class CustomerAuthController extends Controller
{

    public function login(Request $request)
    {

        $input = $request->only('email', 'password');
        $token = null;

        
        if (!$token = auth()->guard('customer')->attempt($input)) {

            return $this->outputJSON('', 'Usuário ou senha inválidos', true, 401);
        }

        $customer = Customer::where('email', $request->email)->firstOrFail();
        
        if(is_null($customer->email_verified_at)){
            return $this->outputJSON('MAIL_VERIFY', 'Email verification required', true, 401);
        }

        return $this->outputJSON($token, '', false, 200);
    }

    public function logout(Request $request)
    {
        try {

            auth()->guard('customer')->logout();
            return $this->outputJSON('', 'Customer logged out successfully', false, 200);
        } catch (JWTException $exception) {

            return $this->outputJSON('', $exception->getMessage(), true, 500);
        }
    }
    public function logged()
    {
        auth()->user()->update(['last_activity' => now()]);
        return $this->outputJSON(auth()->user()->with('subscription', 'address')->find(auth()->user()->id), '', false, 200);
    }
}
