<?php

namespace App\Imports;

use App\Models\Disc\Disc;
use App\Models\Disc\DiscIntensity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DiscIntensitiesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){

            DiscIntensity::firstOrCreate([
                'disc_id' => Disc::where('letter', $row[0])->first()->id,
                'number' => $row[1],
                'name' => $row[2],
                'description' => $row[3]
            ]);
        }
    }
}
