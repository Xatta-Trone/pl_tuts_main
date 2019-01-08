<?php

namespace App\Mail;

use App\Model\User\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contact_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contact_data = $contact_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        echo $this->contact_data; exit;
        return $this->subject('Feedback Reply')
                    ->replyTo('pltutorialsbuet@gmail.com')
                    ->view('email.contactsubmission');
    }
}
