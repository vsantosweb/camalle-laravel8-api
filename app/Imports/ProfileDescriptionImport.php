<?php

namespace App\Imports;

use App\Models\Disc\DiscProfile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProfileDescriptionImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $discProfiles = DiscProfile::all();
        foreach ($discProfiles as $profile) {
            foreach ($rows as $row) {
                if($profile->name == $row[0]){
                    $profile->description = json_decode(str_replace(["\n", "\r"], '', $row[1]), true);
                    $profile->save();
                }
            }
        }
    }
}
