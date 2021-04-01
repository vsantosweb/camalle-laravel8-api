<?php

namespace App\Models\Respondent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondentDiscMessageQueue extends Model
{
    protected $fillable = ['run', 'description'];
    protected $casts = ['run' => 'boolean'];

    protected $hidden = ['respondent_disc_message_id', 'created_at', 'updated_at', 'id'];
    public $timestamp = false;

    public function message()
    {
        return $this->belongsTo(RespondentDiscMessage::class);
    }
}
