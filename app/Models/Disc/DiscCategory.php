<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];
    protected $hidden = ['updated_at', 'created_at'];

    public function combinations()
    {
        return $this->hasMany(DiscCombinations::class);
    }

    public function report()
    {
        return $this->hasMany(DiscCategoryReport::class);
    }
}
