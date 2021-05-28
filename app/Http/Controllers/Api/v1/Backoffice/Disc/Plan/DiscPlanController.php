<?php

namespace App\Http\Controllers\Api\v1\Backoffice\Disc\Plan;

use App\Http\Controllers\Controller;
use App\Models\Disc\DiscPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(
        DiscPlan $discPlan
    ) {
        $this->discPlan = $discPlan;
    }
    public function index()
    {
        $plans = $this->discPlan->with('periods');

        $plans = isset(request()->name) ? $plans->where('name', 'like',  '%' . request()->name . '%') : $plans;
        $plans = isset(request()->email) ? $plans->where('email', request()->email) : $plans;

        $result = isset(request()->paginate) ? $plans->paginate(request()->paginate) : $plans->get();

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

            $newDiscPlan = $this->discPlan->firstOrCreate([
                'code' => Str::random(15),
                'name' => $request->name,
                'slug' =>  Str::slug($request->name),
                'price' => $request->price,
                'features' => $request->features,
                'description' => $request->description,
                'showcase' => $request->showcase,
            ]);

            return $this->outputJSON($newDiscPlan, '', false, 201);
        } catch (\Throwable $th) {
            $this->outputJSON([], $th, true, 500);
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

            $updatedDiscPlan = $this->discPlan->update($request->all());
            return $this->outputJSON($updatedDiscPlan, '', false);
        } catch (\Throwable $th) {
            $this->outputJSON([], $th, true, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        try {

            $updatedDiscPlan = $this->discPlan->where('code', $code)->first();
            $updatedDiscPlan->delete();

            return $this->outputJSON([], '', false);
        } catch (\Throwable $th) {
            $this->outputJSON([], $th, true, 500);
        }
    }
}
