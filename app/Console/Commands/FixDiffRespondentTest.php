<?php

namespace App\Console\Commands;

use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscTest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FixDiffRespondentTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:respondents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $respondents = DB::table('respondents')->where('customer_id', 1)->distinct()->get();
        $originalTests = DB::table('respondent_disc_tests2')->distinct()->get();

        foreach ($respondents as $respondent) {
            DB::table('respondent_disc_tests')->insert([
                'was_finished' => 0,
                'code' => Str::random(15),
                'metadata' =>0,
                'respondent_id' => $respondent->id,
                'created_at' => $respondent->created_at,
                'updated_at' => $respondent->updated_at
            ]);
        }

        $tests = DB::table('respondent_tests')->distinct()->get();

        foreach ($tests as $test) {
            foreach ($originalTests as $originalTest) {
                if ($test->respondent_id == $originalTest->respondent_id) {

                    DB::table('respondent_disc_tests')->where('respondent_id', $originalTest->respondent_id)->update([
                        'metadata' => $originalTest->metadata,
                        'was_finished' => 1,
                        'code' => Str::random(15),
                        'respondent_id' => $originalTest->respondent_id,
                        'created_at' => $originalTest->created_at,
                        'updated_at' => $originalTest->updated_at,
                    ]);
                }
            }
        }

        // echo count($total);
    }
}
