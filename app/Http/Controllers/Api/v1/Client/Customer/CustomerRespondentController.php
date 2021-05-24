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

        $respondents = auth()->user()->respondents();

        $respondents = isset(request()->name) ? $respondents->where('name', 'like',  '%' . request()->name . '%') : $respondents;
        $respondents = isset(request()->email) ? $respondents->where('email', request()->email) : $respondents;

        $respondents = $respondents->with('lists', function ($query) {
            $query->select('name');
        })
            ->withCount('reports');

        $result = isset(request()->page) ? $respondents->paginate(25) : $respondents->get();

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

            $newRespondent = auth()->user()->respondents()->firstOrcreate(
                ['email' => $request->email],
                [
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'custom_fields' => $request->custom_fields,
            ]);

            $newRespondent->lists()->attach($request->respondent_lists);

            return $this->outputJSON($newRespondent->with('lists')->find($newRespondent->id), 'Success', false);
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
        return $this->outputJSON($respondent->with('lists', 'reports')->first(), 'Success', false);
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

    public function removeFromList()
    {
        // $respondent = auth()->user()->respondents()->whereIn('uuid', $request->uuids)->detach();

    }
}
