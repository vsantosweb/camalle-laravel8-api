<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerProfileController extends Controller
{
    public function showProfile()
    {
        return $this->outputJSON(auth()->user()->load('address'), [], false, 200);
    }

    public function updateProfile(Request $request)
    {

        try {
            auth()->user()->update($request->all());

            if (auth()->user()->address->isEmpty()) {
                auth()->user()->address()->create($request->address);
            }

            if (isset($request->address)) {
                auth()->user()->address()->update($request->address);
            }

            return $this->outputJSON(auth()->user()->load('address'), 'Sucesss', 200);

        } catch (\Exception $e) {

            return $this->outputJSON([], 'false', $e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['min:8', 'confirmed', 'required'],
        ]);
        if ($validator->fails()) {

            return $this->outputJSON([], 'true', $validator->errors(), 400);
        }

        try {

            auth()->user()->update(['password' => Hash::make($request->password)]);

            return $this->outputJSON([], 'Success', 200);
        } catch (\Exception $e) {

            return $this->outputJSON([], 'false', $e->getMessage(), 500);
        }
    }

    public function generateApicredential()
    {
        $apiCredential = auth()->user()->api_token = hash('sha256', auth()->user()->email . env('APP_KEY'));
        auth()->user()->save();
        return $this->outputJSON($apiCredential, '', false, 200);
    }
}
