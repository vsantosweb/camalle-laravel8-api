<?php

namespace App\Models\Respondent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondentDemographic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'graduate',
        'current_occupation',
        'occupation',
        'nationality',
        'ancestors',
        'hometown',
        'age',
        'birthday',
        'gender',
        'metadata'
    ];

}
