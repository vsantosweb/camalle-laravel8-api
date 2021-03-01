<?php

namespace App\Models\Customer;

use App\Models\Disc\DiscPlan;
use App\Models\Disc\DiscPlanSubscription;
use App\Models\Order\Order;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentCustomField;
use App\Models\Respondent\RespondentList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'email_verified_at'
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

    public function address()
    {
        return $this->hasOne(CustomerAddress::class);
    }
    public function subscription()
    {
        return $this->hasOne(DiscPlanSubscription::class)->with('plan');
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

}
