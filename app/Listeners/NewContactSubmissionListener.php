<?php

namespace App\Listeners;

use App\Events\NewContactSubmission;
use App\Mail\NewContactSubmissionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewContactSubmissionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewContactSubmission  $event
     * @return void
     */
    public function handle(NewContactSubmission $event)
    {
        $contact_data = $event->contact_data;
        //echo $contact_data;exit;
        echo Mail::to('pltutorialsbuet@gmail.com')->send(new NewContactSubmissionMail($contact_data));
    }
}
