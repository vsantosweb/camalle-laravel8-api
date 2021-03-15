<?php

namespace App\Imports;

use App\Models\Respondent\Respondent;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class ContactsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    public function __construct($listImport)
    {
        $this->listImport = $listImport;
    }

    public function collection(Collection $rows)
    {
        $defaultFields = [];
        $customFields = [];
        $columFields = $rows[0];

        if (str_replace(['-', '_'], '', strtolower($columFields[0])) !== 'email' || str_replace(['-', '_'], '', strtolower($columFields[1])) !== 'name') {
            $this->listImport->status = 3;
            
            throw new \Exception("Error Processing Request: Invalid layout format", 1);
        }

        $createdItems = [];
        $updated = $this->updated($rows);

        for ($i = 0; $i < count($columFields); $i++) {

            $field = str_replace(['-', '_'], '', strtolower($columFields[$i]));
            if (Schema::hasColumn('respondents', $field)) {
                $defaultFields[] =  $field;
            } else {
                $customFields[] = $field;
            }
        }

        foreach ($rows as $row => $value) {

            $test = $value;
            if ($row == 0) continue;
            $defaultInserts = [];

            for ($i = 0; $i < count($defaultFields); $i++) {
                $defaultInserts[$defaultFields[$i]] =  $value[$i];
            }
            if (filter_var($defaultInserts['email'], FILTER_VALIDATE_EMAIL)) {

                if (is_null(Respondent::where('email', $defaultInserts['email'])->first())) {
                    array_push($createdItems, $defaultInserts['email']);
                }

                $newRespondent = Respondent::updateOrCreate(
                    ['email' => $defaultInserts['email']],
                    [
                        'name' => $defaultInserts['name'],
                        'uuid' => Str::uuid(),
                        'customer_id' =>  $this->listImport->respondentList->customer->id,
                    ]
                );

                $newRespondent->lists()->attach([$this->listImport->respondentList->id]);
            }

            $customValues = array_slice($value->toArray(), count($defaultInserts));
            $newCustomFields = [];
            for ($i = 0; $i < count($customFields); $i++) {

                $newCustomFields[$i]['name'] = $customFields[$i];
                $newCustomFields[$i]['key'] = Str::snake($customFields[$i]);

                if (is_numeric($customValues[$i])) {

                    if ($this->isDate(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($customValues[$i]))) {
                        $newCustomFields[$i]['type'] = 'date';
                        $newCustomFields[$i]['value'] = $this->isDate(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($customValues[$i]));
                    }
                } else {
                    $newCustomFields[$i]['type'] = 'text';
                    $newCustomFields[$i]['value'] = $customValues[$i];
                }
            }
            $newRespondent->custom_fields = $newCustomFields;
            $newRespondent->save();
        }

        $this->listImport->update([
            'log' => [
                $updated,
                $this->duplicates($rows),
                $this->invalids($rows)
            ],
            'status' => 1,
            'created_items' => count($createdItems),
            'total_items' => count($rows)
        ]);
    }

    private function isDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date->format('d-m-Y'));

        if ($d && $d->format($format) !=  $date->format('d-m-Y')) {
            return false;
        }

        return $d->format('Y-m-d');
    }

    private function duplicates($rows)
    {
        $duplicates = [];

        for ($i = 1; $i < count($rows); $i++) {
            array_push($duplicates, $rows[$i][0]);
        }
        $duplicatesResult =  array_unique(array_diff_assoc($duplicates, array_unique($duplicates)));

        $duplicates = [];

        foreach ($duplicatesResult as $result) {
            $duplicates[] = $result;
        }

        return [
            'duplicates' => [
                'total' => count($duplicatesResult),
                'items' => $duplicates
            ]
        ];
    }

    private function updated($rows)
    {
        $updated = [];

        for ($i = 1; $i < count($rows); $i++) {
            array_push($updated, $rows[$i][0]);
        }
        $respondents = Respondent::whereIn('email', $updated)->pluck('email')->toArray();

        return [
            'updated' => [
                'total' => count($respondents),
                'items' => $respondents
            ]
        ];
    }

    private function invalids($rows)
    {
        $invalids = [];

        for ($i = 1; $i < count($rows); $i++) {

            if (!filter_var($rows[$i][0], FILTER_VALIDATE_EMAIL)) {
                array_push($invalids, $rows[$i][0]);
            }
        }
        return [
            'invalids' => [
                'total' => count($invalids),
                'items' => $invalids
            ]
        ];
    }
}
