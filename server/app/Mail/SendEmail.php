<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $stringNumber;


    public function __construct($stringNumber)
    {
        $this->stringNumber = $stringNumber;
    }


    public function build()
    {
        return $this
        ->view('emails.SendEmail')
        ->from('phpd0505@gmail.com', 'Piece Of Case')
        ->subject('您的Piece Of Case驗證碼');
    }
}