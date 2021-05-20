<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Disc\Plan;

use App\Http\Controllers\Controller;
use App\Models\Disc\DiscPlanSubscription;
use Illuminate\Http\Request;

class DiscPlanSubscriptionController extends Controller
{

    public function __construct(DiscPlanSubscription $discPlanSubscription){

        $this->discPlanSubscription = $discPlanSubscription;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->discPlanSubscription->with(['customer' => function($query){
            $query->select('id', 'name', 'company_name');
        }])->get();

        return $customers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
