<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Disc;

use App\Http\Controllers\Controller;
use App\Models\Disc\Disc;
use App\Models\Disc\DiscIntensity;
use App\Models\Disc\DiscQuestion;
use App\Models\Disc\DiscSession;
use Illuminate\Http\Request;

class DiscController extends Controller
{

    public function __construct
    (
        Disc $disc,
        DiscQuestion $discQuestion,
        DiscSession $discSession,
        DiscIntensity $discIntensities
    )
    {
        $this->disc = $disc;
        $this->discQuestion = $discQuestion;
        $this->discSession = $discSession;
        $this->discIntensities = $discIntensities;
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
