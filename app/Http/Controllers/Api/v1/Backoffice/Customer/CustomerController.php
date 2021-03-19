<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        try {

            $newCustomer = $this->customer->fisrtOrCreate([
                'uuid' => Str::uuid(),
                'password' => Hash::make($request->password),
            ],[
                
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'document_1' => $request->document_1,
                'document_2' => $request->document_2,
                'company_name' => $request->company_name,
                'company_document' => $request->company_document,
                'phone' => $request->phone,
                'customer_type_id' => $request->customer_type_id,
                'notify' =>  $request->notify,
                'newsletter' => $request->newsletter,
                'email_verified_at' => now()
            ]);

            return $this->outputJSON($newCustomer, 'Success', false, 201);

        } catch (\Throwable $th) {

            return $this->outputJSON([], $th, true, 500);
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

    public function online()
    {

        return $this->customer->where('last_activity', '>', now()->subMinutes(5)->format('Y-m-d H:i:s'))->get();
    }
}
