<?php

namespace App\Imports;

use App\Models\Disc\DiscRanges;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DiscRangeImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $discRange = DiscRanges::firstOrCreate([
                'letter' => $row[1],
                'segment' => $row[3]
            ]);

            $letters[] = $discRange->letter;
            $segments[] = $discRange->segment;
        }

        $letters = array_values(array_unique($letters));
        $segments = array_values(array_unique($segments));
        print_r($segments);

        // dd($discRange->segment);

        for ($j = 0; $j < count($segments); $j++) {
            for ($i = 0; $i < count($letters); $i++) {

                foreach ($rows as $row) {
                    if(!is_null($row[2])){
                        if ($row[1] == $letters[$i]  && $row[3] == $segments[$j]) {
                            $result[$letters[$i]][] = $row[2];
                        }
                    }
                }
            }
        }
    }
}
