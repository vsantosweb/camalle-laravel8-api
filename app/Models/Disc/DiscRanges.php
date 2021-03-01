<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscRanges extends Model
{
    use HasFactory;

    protected $fillable = [
        'disc_id',
        'range',
        'segment_id',
    ];
    protected $casts = ['range' => 'object'];

    public function disc()
    {
        return $this->belongsTo(Disc::class);
    }
    public function segment()
    {
        return $this->belongsTo(DiscSegment::class);
    }

    public function graphType()
    {
        return $this->belongsTo(DiscGraphType::class, 'disc_graph_type_id');
    }
}
