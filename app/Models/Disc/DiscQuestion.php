<?php

namespace App\Models\Disc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'uuid'];
    protected $hidden = ['updated_at', 'created_at'];

    public function options()
    {
        return $this->hasMany(DiscQuestionOption::class);
    }
}
