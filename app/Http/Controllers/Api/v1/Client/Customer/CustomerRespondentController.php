<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Models\Respondent\Respondent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerRespondentController extends Controller
{

    public function __construct(Respondent $respondent)
    {
        $this->respondent = $respondent;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->outputJSON(auth()->user()->respondents()->with('discTests', 'list')->get(), 'Success', false);
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

            $newRespondent = auth()->user()->respondents()->firstOrcreate([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'respondent_list_id' => $request->respondent_list_id,
                'custom_fields' => $request->custom_fields,
            ]);


            return $this->outputJSON($newRespondent->with('list')->find($newRespondent->id), 'Success', false);
        } catch (\Exception $e) {

            return $this->outputJSON('', $e->getMessage(), false);
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
        $respondent = auth()->user()->respondents()->where('uuid', $uuid);
        return $this->outputJSON($respondent->with('list', 'discTests')->first(), 'Success', false);
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

            $respondent = auth()->user()->respondents()->findOrFail($id);
            $respondent->update($request->all());

            return $this->outputJSON($respondent->with('list')->first(), 'Success', false);
        } catch (\Exception $e) {

            return $this->outputJSON('', $e->getMessage(), false);
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

            $respondent = auth()->user()->respondents()->whereIn('uuid', $request->uuids)->delete();

            return $this->outputJSON($respondent, 'Success', false);
        } catch (\Exception $e) {

            return $this->outputJSON('', $e->getMessage(), false);
        }
    }
}
