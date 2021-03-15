<?php

namespace App\Http\Controllers\Api\v1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Models\Respondent\RespondentList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerRespondentListController extends Controller
{

    public function __construct(RespondentList $respondentList)
    {
        $this->respondentList = $respondentList;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $respondentLists = auth()->user()->respondentLists()
        ->with('respondents', function($query){
            $query->select('id', 'name', 'email');
        })->withCount('respondents')->orderBy('created_at', 'desc');

        $result = isset(request()->page) ? $respondentLists->paginate(25) : $respondentLists->get();
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

            $newRespondentList = auth()->user()->respondentLists()->firstOrcreate([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'description' => $request->description,
                'settings' => $request->settings
            ]);

            return $this->outputJSON($newRespondentList, '', false);
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
        $respondentList = auth()->user()->respondentLists()->where('uuid', $uuid)->with('respondents')->firstOrFail();
        return $this->outputJSON($respondentList, 'Success', false);
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
        $respondentList = auth()->user()->respondentLists()->findOrFail($id);

        try {
            $respondentList->update($request->all());

            return $this->outputJSON($respondentList, 'Success', false);
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
            $respondentList = auth()->user()->respondentLists()->whereIn('uuid', $request->uuids)->forceDelete();
            return $this->outputJSON(auth()->user()->respondentLists()->with('respondents')->get(), 'Success', false);
        } catch (\Exception $e) {
            return $this->outputJSON('', $e->getMessage(), true, 500);
        }
    }

    public function uploadFile(Request $request)
    {

        $fileToUpload = auth()->user()->respondentLists()->where('uuid', $request->respondent_list_uuids[0])->firstOrFail();

         explode(';',$request->fileBase64);

        try {
            $fileToUpload->acceptedFileFormat($request->file_format);
            $fileToUpload->uploadFile($request->all());
            
            return $this->outputJSON($fileToUpload, 'Success', false, 201);
        } catch (\Exception $e) {
            return $this->outputJSON('', $e->getMessage(), true, 500);
        }
    }
}
