<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscIntensity extends Model
{
    use HasFactory;

    protected $fillable = [
        'disc_id',
        'number',
        'name',
        'description'
    ];

    public function disc()
    {
        return $this->belongsTo(Disc::class);
    }
}
