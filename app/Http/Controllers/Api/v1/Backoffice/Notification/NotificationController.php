<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Notification;

use App\Events\Customer\CustomerNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $customers = Customer::with('notifications')->whereIn('uuid', $request->to)->get();

        if ($customers->isEmpty()) return $this->outputJSON([], 'No results', false, 404);

        try {

            $customers->map(function ($customer) use ($request) {

                $customer->notifications()->create([

                    'type' => 'system',
                    'title' => $request->title,
                    'data' =>  $request->data,

                ]);

                event(new CustomerNotificationEvent($customer->notifications()->where('read_at', NULL)->get(), $customer));

                return $customer;
            });

            return $this->outputJSON($customers, '', false, 201);
            
        } catch (\Throwable $th) {

            return $this->outputJSON($th->getMessage(), '', false, 500);
        }
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
