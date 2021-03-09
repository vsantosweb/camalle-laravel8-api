<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Models\Disc\Disc;
use App\Models\Respondent\RespondentDiscTest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerDiscController extends Controller
{
    public function create(Request $request)
    {

        if (!auth()->user()->subscription->status) {
            return $this->outputJSON([], 'subscription disabled', false);
        }

        $disc = new Disc;

        try {
            return $this->outputJSON($disc->generateTestDiscToList($request), 'Envio para listas realizado com sucesso!', false, 200);
        } catch (\Exception $e) {
            return $this->outputJSON('', $e->getMessage(), true, 200);
        }
    }

    public function filter(Request $request)
    {
        $discTestQuery =  DB::table('respondent_disc_tests AS test')
            ->select('test.code as disc_test_code', 'test.was_finished', 'test.created_at', 'test.updated_at', 'respondent.name', 'respondent.email', 'respondent.custom_fields')
            ->join('respondents AS respondent', 'test.respondent_email', '=', 'respondent.email')
            ->join('respondent_lists AS respondentLists', 'respondentLists.id', '=', 'respondent.respondent_list_id')
            ->join('customers AS customer', 'customer.id', 'respondent.customer_id')->where('respondent.customer_id', auth()->user()->id);

        $discTestQuery = isset($request->was_finished) ? $discTestQuery->where('was_finished', $request->was_finished) : $discTestQuery;
        $discTestQuery = isset($request->email) ? $discTestQuery->where('respondent.email', $request->email) : $discTestQuery;
        $discTestQuery = isset($request->code) ? $discTestQuery->where('test.code', $request->code) : $discTestQuery;
        $discTestQuery = isset($request->list) ? $discTestQuery->where('respondentLists.uuid', $request->list) : $discTestQuery;

        return $this->outputJSON($discTestQuery->get(), '', false);
    }
}
