<?php

namespace App\Models\Respondent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondentDiscMessage extends Model
{
    protected $fillable = [
        'uuid',
        'customer_id',
        'respondent_disc_report_id',
        'name',
        'subject',
        'sender_name',
        'content',
        'status',
        'report',
        'respondent_lists',
        'bounce',
    ];

    public function RespondentDiscReport()
    {
        return $this->hasMany(RespondentDiscReport::class, 'message_uuid', 'uuid');
    }

    public function lists()
    {
        return $this->belongsToMany(RespondentList::class, 'respondent_lists_to_messages');
    }

    public function respondents()
    {
        return $this->belongsToMany(Respondent::class,'respondent_disc_reports', 'respondent_id', 'respondent_disc_message_id');
    }

    public function queue()
    {
        return $this->hasOne(RespondentDiscMessageQueue::class, 'respondent_disc_message_id');
    }
}
