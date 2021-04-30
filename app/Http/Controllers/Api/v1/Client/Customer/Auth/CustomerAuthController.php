<?php

namespace App\Http\Controllers\Api\v1\Client\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class CustomerAuthController extends Controller
{

    public function login(Request $request)
    {

        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = auth()->guard('customer')->attempt($input)) {

            return $this->outputJSON('','Invalid email or password', true, 401);
        }

        return $this->outputJSON($token, '', false, 200);
    }

    public function logout(Request $request)
    {
        try {
            auth()->guard('customer')->logout();

            return $this->outputJSON('','Customer logged out successfully', false ,200);
        } catch (JWTException $exception) {

            return $this->outputJSON('',$exception->getMessage(), true, 500);
        }
    }
    public function logged()
    {
        auth()->user()->update(['last_activity' => now()]);
        return $this->outputJSON(auth()->user()->with('subscription', 'address')->find(auth()->user()->id),'', false, 200);
    }

}
