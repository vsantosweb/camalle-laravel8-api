<?php

namespace App\Http\Controllers\Api\v1\Client\Disc;

use App\Http\Controllers\Controller;
use App\Mail\mailToOwners;
use App\Models\Disc\DiscCombination;
use App\Models\Disc\DiscRanges;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDemographic;
use App\Models\Respondent\RespondentDiscSession;
use App\Models\Respondent\RespondentDiscReport;
use App\Notifications\TestFinished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class DiscSessionController extends DiscController
{
    public function start(Request $request)
    {
        try {
            $respondentDiscSession = RespondentDiscSession::where('token', $request->token)->where('was_finished', 0)->with('respondent')->firstOrFail();

            $respondentDiscSession->update([
                'active' => 1,
                'ip' => $request->ip(),
                'last_activity' => now(),
                'user_agent' => $request->userAgent()
            ]);

            if (is_null($respondentDiscSession)) {

                return $this->outputJSON([], 'Invalid session', true, 401);
            }

            $respondentDiscSession->update(['active' => true]);

            return $this->outputJSON($respondentDiscSession, '', false);
        } catch (\Throwable $e) {

            return $this->outputJSON([], $e->getMessage(), true, 400);
        }
    }

    public function finish(Request $request)
    {

        $respondentDiscSession = RespondentDiscSession::where('token', $request->token)->where('was_finished', 0)->with('respondent')->firstOrFail();
        $respondentTest = RespondentDiscReport::where('code', $request->disc_test_code)->where('was_finished', 0)->firstOrFail();

        $graphs = $request->graphs;
        // dd( $graphs);

        for ($i = 0; $i < count($graphs); $i++) {

            foreach ($graphs[$i]['graphLetters'] as $letter => $value) {

                foreach (DiscRanges::all() as $discRanges) {
                    if ($discRanges->graphType->name == $graphs[$i]['graphName']) {
                        foreach ($discRanges->range as $rangeIntensity) {
                            if ($letter == $discRanges->disc->letter) {
                                if (false !== array_search($value, $rangeIntensity->range)) {
                                    $profile[$graphs[$i]['graphName']][] = $discRanges->segment->number;
                                    $intensities[$graphs[$i]['graphName']][] =  $rangeIntensity->intensity;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (count($profile['difference']) < 4) {

            return 'Combinação inválida';
        }

        $code = $profile['difference'][0] . $profile['difference'][1] . $profile['difference'][2] . $profile['difference'][3];

        $combination = DiscCombination::where('code', $code)->with('profile', 'category')->first();
        $combination->intensities = $intensities;
        $combination->graphs = $request->graphs;

        if ($combination->disc_profile_id == 3) {
            return $this->outputJSON('Desvio', '', true, 200);
        }



        $respondentTest->update([
            'metadata' => $combination,
            'was_finished' => 1,
            'ip' => $request->ip(),
            'category' => $combination->category->name,
            'profile' => $combination->profile->name,
            'user_agent' => $request->userAgent(),
        ]);

        $respondentDiscSession = RespondentDiscSession::where('token', $request->token)->first();

        $respondentDiscSession->session_data = $request->session_data;
        $respondentDiscSession->save();

        $respondentDiscSession->update([
            'active' => 0,
            'was_finished' => 1,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);


        if ($request->demographic_data) {

            $newDemograph = RespondentDemographic::create($request->demographic_data);
            $newDemograph->metadata = ['intensities ' => $combination->intensities, $combination->graphs, $combination->profile->name . ' ' . $combination->category->name];
            $newDemograph->save();
        }


        // if (isset($request->respondent_uuid)) {

        //     if (!empty($respondent->list->settings->ownerMailList)) {
        //         Notification::route('mail', $respondent->list->settings->ownerMailList)->notify(new TestFinished($respondentTest));
        //     }

        // }


        return $this->outputJSON($respondentDiscSession, '', false);
    }
}
