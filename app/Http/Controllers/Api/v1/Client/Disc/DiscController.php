<?php

namespace App\Http\Controllers\Api\v1\Client\Disc;

use App\Http\Controllers\Api\v1\Backoffice\Disc\DiscController as DiscBackofficeController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscController extends DiscBackofficeController
{
    public function create(Request $request)
    {
        return $request->all();
    }
    public function questions()
    {
        return $this->outputJSON($this->discQuestion->with('options')->get(),'', false);
    }

    public function questionShow($uuid)
    {
        return $this->outputJSON($this->discQuestion->where('uuid', '$uuid')->with('options')->get(),'', false);
    }

    public function intensities()
    {
        return $this->outputJSON( $this->discIntensities->with('disc')->get(),'', false);

    }
}
