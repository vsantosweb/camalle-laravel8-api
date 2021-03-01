<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscGraphType extends Model
{
    protected $fillable = ['name'];

    public function ranges(){
        return $this->hasMany(DiscRanges::class);
    }
}
