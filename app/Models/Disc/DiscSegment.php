<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscSegment extends Model
{
    use HasFactory;

    public function intensities()
    {
        return $this->hasMany(DiscRanges::class, 'segment_id');
    }
}
