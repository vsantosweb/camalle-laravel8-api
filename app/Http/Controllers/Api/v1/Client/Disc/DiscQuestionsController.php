<?php

namespace App\Http\Controllers\Api\v1\Client\Disc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscQuestionsController extends DiscController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->outputJSON($this->discQuestion->with('options')->get(),'', false);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        return $this->outputJSON($this->discQuestion->where('uuid', $uuid)->with('options')->firstOrFail(),'', false);
    }
}
