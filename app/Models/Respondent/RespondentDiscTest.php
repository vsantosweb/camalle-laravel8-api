<?php

namespace App\Models\Respondent;

use App\Models\Disc\DiscCombination;
use App\Models\Disc\DiscRanges;
use App\Models\Respondent\Respondent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondentDiscTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_id',
        'respondent_name',
        'respondent_email',
        'message_uuid',
        'category',
        'profile',
        'metadata',
        'ip',
        'geolocation',
        'was_finished',
        'user_agent'
    ];

    protected $casts = ['metadata' => 'object'];

    public function respondent()
    {
        return $this->belongsTo(Respondent::class);
    }

    public function respondenetDiscTestMessage()
    {
        return $this->belongsTo(RespondentDiscTestMessage::class, 'uuid', 'message_uuid');
    }
    
    public static function makeReport($respondents = [])
    {
        $respondentTests = RespondentDiscTest::where('was_finished', 1)->get();

        $currentGraphs = [];

        foreach ($respondentTests as $test) {

            $currentGraphs[] = $test->metadata->graphs;
        }
        
        $graphs = $currentGraphs;

        for ($i = 0; $i < count($graphs); $i++) {
            for ($j = 0; $j < count($graphs[$i]); $j++) {
                foreach ($graphs[$i][$j]->graphLetters as $letter => $value) {
                    foreach (DiscRanges::all() as $discRanges) {
                        if ($discRanges->graphType->name ==  $graphs[$i][$j]->graphName) {
                            foreach ($discRanges->range as $rangeIntensity) {
                                if ($letter == $discRanges->disc->letter) {
                                    if (false !== array_search($value, $rangeIntensity->range)) {
                                        $profile[$i][$graphs[$i][$j]->graphName][] = $discRanges->segment->number;
                                        $intensities[$i][$graphs[$i][$j]->graphName][] = $rangeIntensity->intensity;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        for ($i = 0; $i < count($profile); $i++) {

            if (count($profile[$i]['difference']) < 4) {

                return 'Combinação inválida';
            }

            $codes[] = $profile[$i]['difference'][0] . $profile[$i]['difference'][1] . $profile[$i]['difference'][2] . $profile[$i]['difference'][3];
            $combination[$i] = DiscCombination::where('code', $codes[$i])->with('profile', 'category')->first();

            $combination[$i]->intensities = json_decode(json_encode($intensities[$i]));
            $combination[$i]->graphs = $currentGraphs[$i];

            $respondentTests[$i]->update([
                'metadata' => $combination[$i],
            ]);
        }



        return "OK";
    }
}
