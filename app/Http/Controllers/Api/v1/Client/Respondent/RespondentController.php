<?php

namespace App\Http\Controllers\Api\v1\Client\Respondent;

use App\Http\Controllers\Controller;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscReport;
use Illuminate\Http\Request;

class RespondentController extends Controller
{
    public function showReport(Request $request)
    {

        try {
            $respondentTest = RespondentDiscReport::where('code', $request->code)->where('respondent_email', $request->respondent_email)->firstOrFail();

            return $this->outputJSON($respondentTest, '', false);
        } catch (\Exception $e) {

            return $this->outputJSON([], $e->getMessage(), true);
        }
    }
}
