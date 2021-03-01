<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscProfile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'uuid', 'slug', 'description'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $casts = ['description' => 'object'];

    public function combinations()
    {
        return $this->hasOne(DiscCombinations::class);
    }

}
