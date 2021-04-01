<?php

namespace App\Models\Disc;

use App\Jobs\JobsSendDiscQuiz;
use App\Mail\Disc\SendDiscTest;
use App\Models\Customer\Customer;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscMessage;
use App\Models\Respondent\RespondentList;
use App\Notifications\SendDiscTestMailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\str;

class Disc extends Model
{
    use HasFactory;

    protected $table = 'disc';
    protected $fillable = ['name', 'letter'];

    public function intensities()
    {
        return $this->hasMany(DiscIntensity::class);
    }


    public function createDiscQuizToRespondent($data)
    {

        auth()->user()->subscription->checkCreditAvaiable(1);

        JobsSendDiscQuiz::dispatch($data, auth()->user()->id, 'respondent')->delay(now()->addSeconds(5));

        auth()->user()->subscription->dispatchCreditConsummation([0]);

    }

    public function createDiscQuizToList($data)
    {


        $lists = RespondentList::whereIn('uuid',  $data['respondent_lists'])->with('respondents')->get();
        $respondents = [];

        foreach ($lists->toArray() as $list) {

            foreach ($list['respondents'] as $respondent) array_push($respondents, $respondent);
        }

        auth()->user()->subscription->checkCreditAvaiable(count($respondents));


        $job = JobsSendDiscQuiz::dispatch($data, auth()->user()->id, 'list')->delay(now()->addSeconds(5));

        auth()->user()->subscription->dispatchCreditConsummation($respondents);

        return $job;

    }
}
