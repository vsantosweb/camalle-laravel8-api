<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscCategoryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'disc_category_id',
        'name',
        'slug',
        'metadata',
    ];
    protected $casts = ['metadata' => 'object'];
}
