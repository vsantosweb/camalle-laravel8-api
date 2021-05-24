<?php

namespace App\Http\Controllers\Api\v1\Backoffice\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserAuthController extends Controller
{

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = auth()->guard('user')->attempt($input)) {

            return $this->outputJSON('', 'Invalid email or password', true, 401);
        }

        return $this->outputJSON($token, '', false, 200);
    }

    public function logout(Request $request)
    {
        try {

            auth()->guard('user')->logout();
            return $this->outputJSON('', ' User logged out successfully', false, 200);
        } catch (JWTException $exception) {

            return $this->outputJSON('', $exception->getMessage(), true, 500);
        }
    }
    public function session()
    {
        return $this->outputJSON(auth()->user(), '', false, 200);
    }
}
