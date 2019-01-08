<?php

namespace App\Mail;

use App\Model\User\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminLoginDetails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $adminData;
    public function __construct($adminData)
    {
        $this->adminData = $adminData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->subject('Admin Login Details')
                    ->replyTo('pltutorialsbuet@gmail.com')
                    ->view('email.adminuserdetails');
    }
}
