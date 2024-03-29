<?php

namespace App\Http\Controllers\Api\v1\Client\Respondent;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RespondentDiscSessionController extends Controller
{

    public function checkSession($token)
    {
        $session = RespondentDiscSession::where('token', $token)->with('respondent')->first();

        if (is_null($session)) return $this->outputJSON([], 'Invalid session', true, 200);

        $session->update(['last_activity' => now()]);

        return $this->outputJSON($session, '', false, 200);
    }

    public function hashLogout(Request $request)
    {
        $location =  \Location::get($request->ip());

        $session = RespondentDiscSession::where('token',  $request->token)->first();

        if (is_null($session)) {
            return $this->outputJSON([], 'Invalid session', true, 400);
        }

        $session->update([
            'token' => Str::random(60),
            'user_agent' => $request->userAgent(),
            'active' => false,
            'was_finished' => true,
            'geolocation' => !$location ? 'Not Avaiable' : $location->longitude . ', ' . $location->latitude,
        ]);

        return $this->outputJSON([], 'Session closed', false, 200);
    }

    public function onlineSessions()
    {
        
        $onlineSessions = RespondentDiscSession::where('last_activity', '>', now()->subMinutes(1)->format('Y-m-d H:i:s'))->get([
            'email',
            'token',
            'session_url',
            'active',
            'user_agent'
        ]);

        return $this->outputJSON($onlineSessions, '', false, 200);
    }
}
