<?php

namespace App\Http\Controllers\Api\v1\Client\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerResetPasswordController extends Controller
{
    public function reset()
    {
        request()->validate([
            'email' => 'required|email|exists:customers',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        
        $passwordResetData = DB::table('password_resets')->where('email', request()->email)->where('token', request()->token);

        if(!$passwordResetData->first()) return $this->outputJSON([], 'Invalid token', 400);

        Customer::where('email', $passwordResetData->first()->email)->update(['password' => Hash::make(request()->password)]);
        
        return $this->outputJSON([], 'Password updated successfully', false, 200);

    }

    public function verifyResetToken()
    {
        
        $passwordResetData = DB::table('password_resets')->where('email', request()->email)->where('token', request()->token);
        if(!$passwordResetData->first()) return $this->outputJSON([], 'Invalid token', 400);
    }
}
