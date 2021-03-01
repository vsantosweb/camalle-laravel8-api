<?php

namespace App\Models\Respondent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondentDiscMessage extends Model
{
    protected $fillable = [
        'uuid',
        'customer_id',
        'respondent_disc_test_id',
        'name',
        'subject',
        'sender_name',
        'content',
        'report',
        'respondent_lists',
        'bounce',
    ];

    public function respondentDiscTest()
    {
        return $this->hasone(RespondentDiscTest::class);
    }

    public function lists()
    {
        return $this->belongsToMany(RespondentList::class, 'respondent_lists_to_messages');
    }

    public function respondents()
    {
        return $this->belongsToMany(Respondent::class,'respondent_disc_tests', 'respondent_id', 'respondent_disc_message_id');

    }
}
