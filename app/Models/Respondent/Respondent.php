<?php

namespace App\Models\Respondent;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;


class Respondent extends Model
{
    use Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'customer_id',
        'respondent_list_id',
        'name',
        'email',
        'status',
        'respondent_list_id',
        'custom_fields'
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
        'custom_fields' => 'object'
    ];

    public function discTests()
    {
        return $this->hasMany(RespondentDiscTest::class, 'respondent_email', 'email');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function list()
    {
        return $this->belongsTo(RespondentList::class, 'respondent_list_id');
    }

    public function messages()
    {
        return $this->belongsToMany(RespondentDiscMessage::class, 'respondent_disc_tests');

    }

    public function discSessions()
    {
        return $this->hasMany(RespondentDiscSession::class, 'email', 'email');
    }
 
}
