<?php

namespace App\Http\Controllers\Api\v1\Client\Disc;

use App\Http\Controllers\Api\v1\Backoffice\Disc\DiscController as DiscBackofficeController;
use App\Http\Controllers\Controller;
use App\Models\Disc\DiscRanges;
use App\Models\Disc\DiscSegment;
use Illuminate\Http\Request;

class DiscController extends DiscBackofficeController
{
    public function create(Request $request)
    {
        return $request->all();
    }
    public function questions()
    {
        return $this->outputJSON($this->discQuestion->with('options')->get(), '', false);
    }

    public function questionShow($uuid)
    {
        return $this->outputJSON($this->discQuestion->where('uuid', '$uuid')->with('options')->get(), '', false);
    }

    public function intensities()
    {
        return $this->outputJSON($this->discIntensities->with('disc')->get(), '', false);
    }

    public function discIntensities()
    {
        return $this->outputJSON($this->disc->with('intensities')->get(), '', false);
    }

    public function graphRelation()
    {
        return DiscSegment::with('intensities')->get();
    }
}
