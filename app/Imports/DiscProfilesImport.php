<?php

namespace App\Imports;

use App\Models\Disc\DiscCategory;
use App\Models\Disc\DiscCategoryReport;
use App\Models\Disc\DiscCombination;
use App\Models\Disc\DiscProfile;
use App\Models\Disc\DiscRanges;
use App\Models\Disc\DiscReport;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class DiscProfilesImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row => $value) {

            $discProfiles = $rows[$row][4];
            $discCategory = $rows[$row][5];

            if (!is_null($discProfiles)) {

                $profile = DiscProfile::firstOrCreate([
                    'name' => $discProfiles,
                    'slug' => Str::slug($discProfiles)
                ]);
            }

            if (!is_null($discCategory)) {
                $category = DiscCategory::firstOrCreate([
                    'name' => $discCategory,
                    'slug' => Str::slug($discCategory)
                ]);
            }

            DiscCombination::firstOrCreate([
                'code' => $value[0] . $value[1] . $value[2] . $value[3],
                'disc_profile_id' => $profile->id,
                'disc_category_id' => $category->id
            ]);

        }

        foreach($category->all() as $category){

            $categoryReportsFile = public_path() . DIRECTORY_SEPARATOR . 'relatorios' . DIRECTORY_SEPARATOR . 'categories'. DIRECTORY_SEPARATOR . $category->slug . '.json';
                $test[] = $categoryReportsFile;
            // if (file_exists($categoryReportsFile)) {

                $report = json_decode(file_get_contents($categoryReportsFile), true);

                DiscCategoryReport::create(
                    [
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'disc_category_id' => $category->id,
                        'metadata' => $report
                    ]
                );
            // }
        }
        print_r($test);
    }
}
