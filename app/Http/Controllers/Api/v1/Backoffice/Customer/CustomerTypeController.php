<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerType;
use Illuminate\Http\Request;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerTypes = new CustomerType();

        $customerTypes = isset(request()->name) ? $customerTypes->where('name', 'like',  '%' . request()->name . '%') : $customerTypes;
        $customerTypes = isset(request()->email) ? $customerTypes->where('email', request()->email) : $customerTypes;

        $result = isset(request()->paginate) ? $customerTypes->paginate(request()->paginate) : $customerTypes->get();

        return $this->outputJSON($result, '', false);
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
