<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscPlanPeriod extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'validity_days'];
    
}
