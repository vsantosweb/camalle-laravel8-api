<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailToOwners extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $discTest;

    public function __construct($discTest)
    {
        $this->discTest = $discTest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = env('APP_URL') . DIRECTORY_SEPARATOR . 'report' . DIRECTORY_SEPARATOR . $this->discTest->code;

        return $this->subject('O respondente ' . $this->discTest->respondent->name . ' finalizou o teste')
            ->view('mails.disc.testFinished' , ['discTest' => $this->discTest, 'url' => $url]);
    }
}
