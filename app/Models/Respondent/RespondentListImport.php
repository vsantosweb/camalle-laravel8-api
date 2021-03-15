<?php

namespace App\Models\Respondent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondentListImport extends Model
{
    protected $fillable = [
        'respondent_list_id',
        'name',
        'uuid',
        'file_size',
        'file_path',
        'file_url',
        'total_items',
        'created_items',
        'status',
        'log',
    ];
    protected $casts = ['log' => 'object'];

    public function respondentList()
    {
        return $this->belongsTo(RespondentList::class);
    }
}
