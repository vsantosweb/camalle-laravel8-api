<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Models\Respondent\RespondentCustomField;
use Illuminate\Http\Request;

class CustomerRespondentCustomFieldController extends Controller
{
    public function __construct(RespondentCustomField $respondentCustomField)
    {
        $this->respondentCustomField = $respondentCustomField;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->outputJSON(auth()->user()->respondentCustomFields()->get(), 'Success', false);
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

            $newRespondentCustomField = auth()->user()->respondentCustomFields()->firstOrCreate($request->all());

            return $this->outputJSON($newRespondentCustomField, 'Success', false);
        } catch (\Exception $e) {

            return $this->outputJSON('', $e->getMessage(), true, 500);
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
        try {

            $newRespondentCustomField = auth()->user()->respondentCustomFields()->findOrfail($id);
            $newRespondentCustomField->update($request->all());

            return $this->outputJSON($newRespondentCustomField, 'Success', false);
        } catch (\Exception $e) {

            return $this->outputJSON('', $e->getMessage(), true, 500);
        }
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

            $newRespondentCustomField = auth()->user()->respondentCustomFields()->whereIn('id', $request->ids)->delete();

            return $this->outputJSON($newRespondentCustomField, 'Success', false);
        } catch (\Exception $e) {

            return $this->outputJSON('', $e->getMessage(), true, 500);
        }
    }
}
