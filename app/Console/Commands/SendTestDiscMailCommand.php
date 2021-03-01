<?php

namespace App\Console\Commands;

use App\Mail\Disc\SendDiscTest;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestDiscMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:disc';

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
        $when = now()->addMinutes(1);

        foreach (Respondent::all() as $respondent) {

            $session =  RespondentDiscSession::firstOrCreate([
                'token' => hash('sha256', microtime()),
                'email' => $respondent->email
            ]);

            $respondent->session = $session;
            Mail::to($session->email)->later($when, new SendDiscTest($respondent));
        }
    }
}
