<?php

namespace App\Mail\Disc;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDiscTest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $respondent;
    protected $session;

    public function __construct($respondent)
    {
       $this->respondent = $respondent;
       $this->session = $respondent->session;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $hashUrl = env('APP_URL') .DIRECTORY_SEPARATOR.'authDisc'. DIRECTORY_SEPARATOR.$this->session->token. DIRECTORY_SEPARATOR . $this->respondent->uuid;
        return $this->subject('Avaliação DISC')->view('mails.disc.sendDiscTestMail', ['respondent'=> $this->respondent, 'hashURL' => $hashUrl]);
    }
}
