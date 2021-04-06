<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Models\Disc\Disc;
use App\Models\Respondent\RespondentDiscMessageQueue;
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
            return $this->outputJSON($disc->createDiscQuizToList($request->all()), 'Envio para listas realizado com sucesso!', false, 200);
        } catch (\Exception $e) {
            return $this->outputJSON('', $e->getMessage(), true, 500);
        }
    }

    public function createToSingleRespondent(Request $request)
    {
        $disc = new Disc;
        return  $disc->createDiscQuizToRespondent($request->all());
    }

    public function show($code)
    {
        $discReport = auth()->user()->discReports()->where('code', $code)->firstOrFail();
        return $this->outputJSON($discReport, '', false, 200);
    }

    public function queues()
    {
        return $this->outputJSON(auth()->user()->messages()->orderBy('created_at', 'desc')->get(), '', false, 200);
    }

    public function filter(Request $request)
    {

        $discTestQuery =  DB::table('respondent_disc_reports AS report')
            ->select(

                'report.code',
                'report.category',
                'report.profile',
                'report.respondent_name',
                'report.respondent_email',
                'report.was_finished',
                'report.created_at',
                'report.updated_at',
            )

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

    public function getQuizSession($code)
    {   
        $reports = auth()->user()->discReports();

        return $this->outputJSON( $reports->where('code', $code)->first()->session, '', false);

        return auth()->user()->discReports;
    }
}
