<?php

namespace App\Jobs;

use App\Models\Customer\Customer;
use App\Notifications\SendDiscTestMailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscMessage;
use App\Models\Respondent\RespondentList;
use Illuminate\Support\str;

class JobsSendDiscQuiz implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $timeout = 60*3;
    public $tries = 3;
    private $data;
    private $sendType;
    private $customer_id;
    public $queue;

    public function __construct($data, $customer_id, $sendType)
    {
        $this->data = $data;
        $this->sendType = $sendType;
        $this->customer_id = $customer_id;
        $this->queue = 'quiz';

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->sendType) {
            case 'list':

                $this->toList();

                break;
            case 'respondent': 

            $this->toRespondent();

            default:
                # code...
                break;
        }
    }

    private function toRespondent()
    {
        $customer = Customer::find($this->customer_id);

        $message = RespondentDiscMessage::create([
            'uuid' => Str::uuid(),
            'customer_id' => $customer->id,
            'name' => $this->data['name'],
            'subject' => $this->data['subject'],
            'content' => $this->data['content'],
            'status' =>'sending',
            'sender_name' => $customer->name
        ]);

        $respondent = Respondent::create([
            'uuid' => Str::uuid(),
            'customer_id' => $customer->id,
            'name' => $this->data['respondent_name'],
            'email' => $this->data['respondent_email'],
        ]);

        $discTest = $respondent->reports()->create([
            'customer_id' => $customer->id,
            'respondent_name' => $respondent->name,
            'message_uuid' => $message->uuid,
            'code' => Str::random(15),
        ]);

        $token = hash('sha256', microtime());

        $respondentSession = $respondent->discSessions()->create([
            'token' => $token,
            'email' => $respondent->email,
            'view_report' => $this->data['view_report'],
            'session_url' => env('APP_URL_DISC_SESSION') . DIRECTORY_SEPARATOR .  '?trackid=' . $token,
            'session_data' => json_decode('{"ref":"' . $discTest->code . '","items":[{"graphName":"less","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"more","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"difference","graphLetters":{"D":0,"I":0,"S":0,"C":0}}]}', TRUE)

        ]);



        $compiledMessage = str_replace('[respondente]', $respondent->name, $message->content);
        $message->content = $compiledMessage;
        $respondent->notify(new SendDiscTestMailNotification($respondentSession,  $message));

        if (!$this->data['save_respondent']) {

            $respondent->forceDelete();
        }
        return $respondentSession;
    }

    private function toList()
    {

        $lists = RespondentList::whereIn('uuid',  $this->data['respondent_lists'])->with('respondents')->get();

        $customer = Customer::find($this->customer_id);

        if ($lists->isEmpty()) {

            throw new \Exception('No registered lists');
        }

        $respondents = [];

        foreach ($lists as $list) {

            foreach ($list->respondents as $respondent) array_push($respondents, $respondent);
        }

        array_map(function ($list) {
            $respondents[] = $list['respondents'];
        }, $lists->toArray());


        $message = RespondentDiscMessage::firstOrCreate([
            'uuid' => Str::uuid(),
            'customer_id' => $customer->id,
            'name' => 'asdasdasdasdasdasdas',
            'subject' => $this->data['subject'],
            'content' => $this->data['content'],
            'status' => 'sending',
            'sender_name' => $customer['name']
        ]);
        
        array_map(function ($list) use ($message) {
            $message->lists()->attach($list['id']);
        }, $lists->toArray());

        $respondentSessions = [];

        foreach ($respondents as $respondent) {

            $discTest = $respondent->reports()->create([
                'customer_id' => $customer->id,
                'respondent_name' => $respondent->name,
                'message_uuid' => $message->uuid,
                'code' => Str::random(15),
            ]);

            $token = hash('sha256', microtime());

            $respondentSession = $respondent->discSessions()->create([
                'token' => $token,
                'email' => $respondent->email,
                'view_report' => $this->data['view_report'],
                'session_url' => env('APP_URL_DISC_SESSION') . DIRECTORY_SEPARATOR .  '?trackid=' . $token,
                'session_data' => json_decode('{"ref":"' . $discTest->code . '","items":[{"graphName":"less","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"more","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"difference","graphLetters":{"D":0,"I":0,"S":0,"C":0}}]}', TRUE)
            ]);

            $respondentSessions[] = $respondentSession;

            $compiledMessage = str_replace('[respondente]', $respondent->name, $message->content);
            $message->content = $compiledMessage;
            $respondent->notify(new SendDiscTestMailNotification($respondentSession,  $message));

        }

        $message->update(['status' => 'sent']);

        return $respondentSessions;
    }
}
