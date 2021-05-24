<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $customers = $this->customer;

        $customers = isset(request()->name) ? $customers->where('name', 'like',  '%' . request()->name . '%') : $customers;
        $customers = isset(request()->email) ? $customers->where('email', request()->email) : $customers;

        $result = isset(request()->paginate) ? $customers->paginate(request()->paginate) : $customers->get();

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

        try {

            $request->validate([
                'email' => 'unique:customers',
            ]);

            $newCustomer = $this->customer->firstOrCreate([
                'uuid' => Str::uuid(),
                'password' => Hash::make($request->password),
            ], [

                'name' => $request->name,
                'email' => $request->email,
                'document_1' => $request->document_1,
                'document_2' => $request->document_2,
                'company_name' => $request->company_name,
                'company_document' => $request->company_document,
                'phone' => $request->phone,
                'customer_type_id' => $request->customer_type_id,
                'email_verified_at' => now()
            ]);

            return $this->outputJSON($newCustomer, 'Success', false, 201);
        } catch (\Throwable $th) {

            return $this->outputJSON($th->errors(), $th->getMessage(), true, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $customer = $this->customer->where('uuid', $uuid)->firstOrFail();
        return $this->outPutJson($customer, '', false, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        try {

            $newCustomer = $this->customer->updateOrCreate([
                'uuid' => $uuid,
            ], [
                'email' => $request->email,
                'name' => $request->name,
                'document_1' => $request->document_1,
                'document_2' => $request->document_2,
                'company_name' => $request->company_name,
                'company_document' => $request->company_document,
                'phone' => $request->phone,
                'customer_type_id' => $request->customer_type_id,
                'email_verified_at' => now()
            ]);

            return $this->outputJSON($newCustomer, 'Success', false, 201);
        } catch (\Throwable $th) {

            return $this->outputJSON([], $th->getPrevious()->errorInfo, true, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $deletedCustomers = $this->customer->whereIn('uuid', request()->customers)->delete();
        return $this->outputJSON($deletedCustomers, 'Success', false, 200);
    }

    public function online()
    {
        return $this->customer->where('last_activity', '>', now()->subMinutes(5)->format('Y-m-d H:i:s'))->get();
    }
}
