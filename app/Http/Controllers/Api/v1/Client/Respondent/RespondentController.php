<?php

namespace App\Http\Controllers\Api\v1\Client\Respondent;

use App\Http\Controllers\Controller;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscReport;
use Illuminate\Http\Request;

class RespondentController extends Controller
{
    public function getTest($code)
    {
        $respondentTest = RespondentDiscReport::where('code', $code)->with('respondent')->firstOrFail();
        return $this->outputJSON($respondentTest, '', false);
    }
}
