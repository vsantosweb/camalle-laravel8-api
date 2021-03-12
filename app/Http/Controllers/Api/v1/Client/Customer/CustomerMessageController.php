<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->outputJSON(auth()->user()->messages()->with('lists')->get(), '', false);
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
    public function show($uuid)
    {
        return $this->outputJSON(auth()->user()->messages()->where('uuid', $uuid)->with('lists')->firstOrFail(), '', false);
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

        $message = auth()->user()->messages()->where('uuid', $uuid)->with('lists')->firstOrFail();
        $message->update($request->all());
        return $this->outputJSON($message, '', false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $messages = auth()->user()->messages()->whereIn('uuid', $request->uuids)->delete();
            return $this->outputJSON($messages, 'Success', false);
        } catch (\Exception $e) {
            return $this->outputJSON('', $e->getMessage(), true, 500);
        }
    }
}
