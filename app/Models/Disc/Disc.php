<?php

namespace App\Models\Disc;

use App\Mail\Disc\SendDiscTest;
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


    public function generateTestDiscToRespondent($data)
    {

        if (auth()->user()->subscription->credits < 1) {

            throw new \Exception('Insufficient credit balance');
        }


        $message = RespondentDiscMessage::create([
            'uuid' => Str::uuid(),
            'customer_id' => auth()->user()->id,
            'name' => $data->name,
            'subject' => $data->subject,
            'content' => $data->content,
            'sender_name' => auth()->user()->name
        ]);

        $respondent = Respondent::create([
            'uuid' => Str::uuid(),
            'customer_id' => auth()->user()->id,
            'name' => $data->respondent_name,
            'email' => $data->respondent_email,
        ]);

        $discTest = $respondent->discTests()->create([
            'customer_id' => auth()->user()->id,
            'respondent_name' => $respondent->name,
            'message_uuid' => $message->uuid,
            'code' => Str::random(15),
        ]);

        $token = hash('sha256', microtime());

        $respondentSession = $respondent->discSessions()->create([
            'token' => $token,
            'email' => $respondent->email,
            'view_report' => $data->view_report,
            'session_url' => env('APP_URL_DISC_SESSION') . DIRECTORY_SEPARATOR .  '?trackid=' . $token,
            'session_data' => json_decode('{"ref":"' . $discTest->code . '","items":[{"graphName":"less","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"more","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"difference","graphLetters":{"D":0,"I":0,"S":0,"C":0}}]}', TRUE)

        ]);

        auth()->user()->subscription->dispatchCreditConsummation([0]);
        

        $compiledMessage = str_replace('[respondente]', $respondent->name, $message->content);
        $message->content = $compiledMessage;
        $respondent->notify(new SendDiscTestMailNotification($respondentSession,  $message));
        
        if(!$data->save_respondent){

            $respondent->forceDelete();
        }
        return $respondentSession;
    }

    public function generateTestDiscToList($data)
    {
        $lists = RespondentList::whereIn('uuid', $data->respondent_lists)->with('respondents')->get();
        // return $lists;
        //testing
        // $lists = RespondentList::all();

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

        if (auth()->user()->subscription->credits < count($respondents)) {

            throw new \Exception('Insufficient credit balance');
        }

        $message = RespondentDiscMessage::create([
            'uuid' => Str::uuid(),
            'customer_id' => auth()->user()->id,
            'name' => $data->name,
            'subject' => $data->subject,
            'content' => $data->content,
            'sender_name' => auth()->user()->name
        ]);

        array_map(function ($list) use ($message) {
            $message->lists()->attach($list['id']);
        }, $lists->toArray());

        $respondentSessions = [];

        foreach ($respondents as $respondent) {

            $discTest = $respondent->discTests()->create([
                'customer_id' => auth()->user()->id,
                'respondent_name' => $respondent->name,
                'message_uuid' => $message->uuid,
                'code' => Str::random(15),
            ]);

            $token = hash('sha256', microtime());

            $respondentSession = $respondent->discSessions()->create([
                'token' => $token,
                'email' => $respondent->email,
                'view_report' => $data->view_report,
                'session_url' => env('APP_URL_DISC_SESSION') . DIRECTORY_SEPARATOR .  '?trackid=' . $token,
                'session_data' => json_decode('{"ref":"' . $discTest->code . '","items":[{"graphName":"less","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"more","graphLetters":{"D":0,"I":0,"S":0,"C":0}},{"graphName":"difference","graphLetters":{"D":0,"I":0,"S":0,"C":0}}]}', TRUE)
            ]);

            $respondentSessions[] = $respondentSession;

            $compiledMessage = str_replace('[respondente]', $respondent->name, $message->content);
            $message->content = $compiledMessage;
            $respondent->notify(new SendDiscTestMailNotification($respondentSession,  $message));
        }

        auth()->user()->subscription->dispatchCreditConsummation($respondents);

        return $respondentSessions;
    }
}
