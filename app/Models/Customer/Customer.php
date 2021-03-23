<?php

namespace App\Models\Customer;

use App\Models\Disc\DiscPlan;
use App\Models\Disc\DiscPlanSubscription;
use App\Models\Order\Order;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentCustomField;
use App\Models\Respondent\RespondentDiscMessage;
use App\Models\Respondent\RespondentDiscReport;
use App\Models\Respondent\RespondentList;
use App\Notifications\RegisterConfirmationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'document_1',
        'document_2',
        'company_name',
        'company_document',
        'phone',
        'customer_type_id',
        'notify',
        'newsletter',
        'last_activity',
        'email_verified_at',
        'first_time',
        'accepted_terms',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * Send email verification account.
     *
     * @return mixed
     */
    public function sendMailVerification()
    {

        try {
            $tokenData = DB::table('email_verifications')->where('email', $this->email)->first();

            if(is_null($tokenData)){
                DB::table('email_verifications')->insert([
                    'email' => $this->email,
                    'token' => Str::random(60),
                    'signature' => Hash::make($this->email . env('APP_KEY')),
                    'created_at' => now()
                ]);
            }
           
            $tokenData = DB::table('email_verifications')->where('email', $this->email)->first();

            $link = env('APP_URL_EMAIL_VERIFY') . '?token=' . $tokenData->token . '&email=' . $tokenData->email;

            $this->notify(new RegisterConfirmationNotification($this, $link));

            return 'Verification email link sent on your email id. ' . $link;
            
        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function address()
    {
        return $this->hasMany(CustomerAddress::class);
    }
    public function subscription()
    {
        return $this->hasOne(DiscPlanSubscription::class)->with('plan');
    }

    public function discReports()
    {
        return $this->hasMany(RespondentDiscReport::class, 'customer_id');
    }

    public function respondents()
    {
        return $this->hasMany(Respondent::class);
    }

    public function respondentLists()
    {
        return $this->hasMany(RespondentList::class);
    }

    public function respondentCustomFields()
    {
        return $this->hasMany(RespondentCustomField::class);
    }

    public function type()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->with('discPlanOrder')->with('status');
    }

    public function messages()
    {
        return $this->hasMany(RespondentDiscMessage::class);
    }
}
