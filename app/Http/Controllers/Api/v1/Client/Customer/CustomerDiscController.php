<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Models\Disc\Disc;
use App\Models\Respondent\RespondentDiscReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if (!auth()->user()->subscription->status) {
            return $this->outputJSON([], 'subscription disabled', false);
        }

        $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'respondent_name' => 'required',
            'respondent_email' => 'required',
        ]);
        
        try {

            $disc = new Disc;
            $response =  $disc->createDiscQuizToRespondent($request->all());
            
            return $this->outputJSON([
                'session_url' => $response->session_url,
            ], 'Envio realizado com sucesso', false, 201);

        } catch (\Exception $e) {

            return $this->outputJSON($e->getMessage(), '', true, 500);
        }
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

        $discTestQuery =  DB::table('respondent_disc_reports as report')->where('report.customer_id', auth()->user()->id);
        $discTestQuery = isset($request->list) ?

            $discTestQuery->where('list.uuid', $request->list)
            ->join('respondents AS respondent', 'report.respondent_email', 'respondent.email')
            ->join('respondents_to_lists', 'respondents_to_lists.respondent_id',  'respondent.id')
            ->join('respondent_lists AS list', 'list.id', 'respondents_to_lists.respondent_list_id')
            ->select('list.name', 'list.uuid') : $discTestQuery;
            
        $discTestQuery
            ->select(
                'report.code',
                'report.category',
                'report.profile',
                'report.respondent_name',
                'report.respondent_email',
                'report.was_finished',
                'report.created_at',
                'report.updated_at'
            );

        $discTestQuery = isset($request->profile) ? $discTestQuery->whereIn('profile', explode(',',  $request->profile)) : $discTestQuery;
        $discTestQuery = isset($request->category) ? $discTestQuery->where('category', $request->category) : $discTestQuery;

        $discTestQuery = isset($request->was_finished) ? $discTestQuery->where('was_finished', $request->was_finished) : $discTestQuery;
        $discTestQuery = isset($request->email) ? $discTestQuery->where('respondent_email', $request->email) : $discTestQuery;
        $discTestQuery = isset($request->respondent_name) ? $discTestQuery->where('respondent_name', 'like', '%' . $request->respondent_name . '%') : $discTestQuery;

        $discTestQuery = isset($request->code) ? $discTestQuery->where('report.code', $request->code) : $discTestQuery;
        $discTestQuery = isset($request->list) ? $discTestQuery->where('list.uuid', $request->list) : $discTestQuery;

        $queryResulType = isset($request->count) ? $discTestQuery->count() : $discTestQuery;

        $queryResulType = (isset($request->paginate) ? $discTestQuery->paginate($request->paginate)
            : (isset($request->count) ? $discTestQuery->count() : $discTestQuery->get()));


        return $this->outputJSON($queryResulType, '', false);
    }

    public function getQuizSession($code)
    {
        $reports = auth()->user()->discReports();

        return $this->outputJSON($reports->where('code', $code)->first()->session, '', false);

        return auth()->user()->discReports;
    }

    public function consultReport()
    {
        $data = request()->only('respondent_email');

        if (empty($data)) {

            return $this->outputJSON([], '', true, 400);
        }

        $report = RespondentDiscReport::where('respondent_email', $data['respondent_email'])
        ->orderBy('was_finished', 'DESC')
        ->orderBy('created_at', 'DESC')
        ->get()
        ->map(function ($report){

            return [
                'respondent_name' => $report->respondent_name,
                'respondent_email' => $report->respondent_email,
                'profile' => $report->profile,
                'category' => $report->category,
                'status' => $report->was_finished ? 'finished' : 'pending',
                'session_url' => !$report->was_finished ? $report->session->session_url: NULL,
                'report_url' =>$report->was_finished ? env('APP_URL') . '/view-report?trackid=' . $report->code : NULL,
                'created_at' => $report->created_at->format('d-m-Y H:i'),
                'finished_at' => $report->was_finished ? $report->updated_at->format('d-m-Y H:i') : NULL,
                'metadata' => $report->metadata 
            ];
        });

        if (!$report->isEmpty()) {

            return $this->outputJSON($report, '', false, 200);
        }


        return $this->outputJSON([], '', true, 404);
    }
}
