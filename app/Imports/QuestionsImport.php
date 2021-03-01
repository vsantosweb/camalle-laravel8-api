<?php

namespace App\Imports;

use App\Models\Disc\DiscQuestion;
use App\Models\Disc\DiscQuestionOption;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Str;

class QuestionsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $discQuestion =  DiscQuestion::firstOrCreate([
                'name' => 'pergunta ' . ($row[0]),
            ]);
        }

        foreach($discQuestion->all() as $question){
            $question->uuid = Str::uuid();
            $question->save();
        }

        foreach ($rows as $row) {

            DiscQuestionOption::firstOrCreate([
                'disc_question_id' => $row[0],
                'name' => $row[1],
                'description' => $row[2],
                'more' => $row[3],
                'less' => $row[4]
            ]);
        }
    }
}
