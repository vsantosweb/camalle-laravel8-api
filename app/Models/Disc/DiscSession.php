<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'expire_at',
        'has_expired',
        'active'
    ];

    public function graph()
    {
        return $this->hasOne(DiscGraph::class);
    }
}
