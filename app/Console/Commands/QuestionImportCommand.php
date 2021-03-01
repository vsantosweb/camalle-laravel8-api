<?php

namespace App\Console\Commands;

use App\Imports\ContactsImport;
use App\Imports\DiscIntensitiesImport;
use App\Imports\DiscProfilesImport;
use App\Imports\ProfileDescriptionImport;
use App\Imports\QuestionsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class QuestionImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

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
        // Excel::import(new ContactsImport, public_path() . DIRECTORY_SEPARATOR . 'planilhas' . DIRECTORY_SEPARATOR . 'contatos_senai_2.xlsx');
        Excel::import(new DiscProfilesImport, public_path() . DIRECTORY_SEPARATOR . 'planilhas' . DIRECTORY_SEPARATOR . 'testeprofile.xlsx');
        Excel::import(new QuestionsImport, public_path() . DIRECTORY_SEPARATOR . 'planilhas' . DIRECTORY_SEPARATOR . 'questions.xlsx');
        Excel::import(new DiscIntensitiesImport, public_path() . DIRECTORY_SEPARATOR . 'planilhas' . DIRECTORY_SEPARATOR . 'disc_intensities.xlsx');
        Excel::import(new ProfileDescriptionImport, public_path() . DIRECTORY_SEPARATOR . 'planilhas' . DIRECTORY_SEPARATOR . 'profile_descricao.xlsx');

        return 0;
    }
}
