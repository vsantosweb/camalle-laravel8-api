<?php

namespace App\Models\Respondent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RespondentDiscSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'token', 'email', 'session_url',
        'was_finished', 'session_data', 'active', 'user_agent',
        'geolocation', 'last_activity', 'expire_at', 'ip'
    ];
    protected $hidden = ['updated_at', 'created_at', 'id'];
    protected $casts = ['session_data' => 'object'];

    public function createToken($respondent)
    {
        $token = $this->create([
            'token' => hash('sha256', Str::random(60)),
            'email' => $respondent->email
        ]);

        $token->uuid = $respondent->uuid;
        return $token;
    }

    public function respondent()
    {
        return $this->belongsTo(Respondent::class, 'email', 'email');
    }

    public function checkSessionToken($token, $uuid)
    {
        if (!is_null($token) && !is_null($uuid)) {

            $respondent = Respondent::where('uuid', $uuid)->first();
            $session = $this::where('token',  $token)->first();

            if (is_null($session) && is_null($respondent)) {
                return false;
            }

            return true;
        }
    }
}
