<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Models\Disc\Disc;
use App\Models\Respondent\RespondentDiscReport;
use App\Models\Respondent\RespondentList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerDiscController extends Controller
{
    public function createToLists(Request $request)
    {

        if (!auth()->user()->subscription->status) {
            return $this->outputJSON([], 'subscription disabled', false);
        }

        $disc = new Disc;

        try {
            return $this->outputJSON($disc->generateTestDiscToList($request), 'Envio para listas realizado com sucesso!', false, 200);
        } catch (\Exception $e) {
            return $this->outputJSON('', $e->getMessage(), true, 500);
        }
    }

    public function createToSingleRespondent(Request $request)
    {
        $disc = new Disc;
        return  $disc->generateTestDiscToRespondent($request);
    }

    public function show($code)
    {
        $discReport = auth()->user()->discReports()->where('code', $code)->firstOrFail();
        return $this->outputJSON($discReport, '', false, 200);
    }

    public function filter(Request $request)
    {
        // $discTestQuery =  DB::table('respondent_disc_reports AS test')
        //     ->select(
        //         'test.code as disc_test_code',
        //         'test.category',
        //         'test.profile',
        //         'test.was_finished',
        //         'test.created_at',
        //         'test.updated_at',
        //         'respondent.name',
        //         'respondent.email',
        //         'respondent.custom_fields'
        //     )
        //     ->join('respondents AS respondent', 'test.respondent_email', 'respondent.email')
        //     ->join('respondents_to_respondent_lists', 'respondents_to_respondent_lists.respondent_id', 'respondent.id')

        //     ->join('customers AS customer', 'customer.id', 'respondent.customer_id')

        //     ->join('respondent_lists AS respondentList', 'customer.id','respondentList.customer_id')
        //     ->where('respondent.customer_id', auth()->user()->id);



        $discTestQuery =  DB::table('respondent_disc_reports AS report')
            ->select(

                // 'list.name as list_name',
                // 'respondent.id',
                'report.code',
                'report.category',
                'report.profile',
                'report.respondent_name',
                'report.respondent_email',
                'report.was_finished',
                'report.created_at',
                'report.updated_at'
            )
            // ->join('respondents AS respondent', 'report.respondent_email', 'respondent.email')

            // ->join('respondents_to_lists', 'respondents_to_lists.respondent_id', 'respondent.id')
            // ->join('respondent_lists AS list', 'respondents_to_lists.respondent_list_id', 'list.id')


            ->where('report.customer_id', auth()->user()->id);

        $discTestQuery = isset($request->profile) ? $discTestQuery->where('profile', $request->profile) : $discTestQuery;
        $discTestQuery = isset($request->category) ? $discTestQuery->where('category', $request->category) : $discTestQuery;

        $discTestQuery = isset($request->was_finished) ? $discTestQuery->where('was_finished', $request->was_finished) : $discTestQuery;
        $discTestQuery = isset($request->email) ? $discTestQuery->where('respondent_email', $request->email) : $discTestQuery;
        $discTestQuery = isset($request->respondent_name) ? $discTestQuery->where('respondent_name', 'like', '%' . $request->respondent_name . '%') : $discTestQuery;
        $discTestQuery = isset($request->list_name) ? $discTestQuery->where('list.name', $request->list_name) : $discTestQuery;

        $discTestQuery = isset($request->code) ? $discTestQuery->where('report.code', $request->code) : $discTestQuery;
        $discTestQuery = isset($request->list) ? $discTestQuery->where('respondentList.uuid', $request->list) : $discTestQuery;

        $queryResulType = isset($request->count) ? $discTestQuery->count() : $discTestQuery;

        $queryResulType = (isset($request->paginate) ? $discTestQuery->paginate($request->paginate)
            : (isset($request->count) ? $discTestQuery->count() : $discTestQuery->get()));


        return $this->outputJSON($queryResulType, '', false);
    }
}
