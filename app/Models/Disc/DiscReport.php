<?php

namespace App\Models\Disc;

use App\Models\Respondent\RespondentDiscSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscReport extends Model
{
    use HasFactory;

    protected $fillable = ['name','metadata', 'disc_profile_id', 'disc_category_id', 'slug', 'code'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $casts = ['metadata' => 'object'];

    public function session()
    {
       return $this->belongsTo(RespondentDiscSession::class, 'respondent_email', 'email');
    }
}
