<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscGraph extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'disc_session_id',
        'graphs',
    ];
    protected $casts = ['graphs' => 'object'];

    public function session()
    {
        return $this->belongsTo(DiscSession::class);
    }
}
