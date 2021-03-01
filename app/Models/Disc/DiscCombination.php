<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscCombination extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'disc_profile_id', 'disc_category_id'];
    protected $hidden = ['updated_at', 'created_at'];

    public function category()
    {
        return $this->belongsTo(DiscCategory::class, 'disc_category_id')->with('report');
    }

    public function profile()
    {
        return $this->belongsTo(DiscProfile::class, 'disc_profile_id');
    }
}
