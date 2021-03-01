<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscReport extends Model
{
    use HasFactory;

    protected $fillable = ['name','metadata', 'disc_profile_id', 'disc_category_id', 'slug', 'code'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $casts = ['metadata' => 'object'];
}
