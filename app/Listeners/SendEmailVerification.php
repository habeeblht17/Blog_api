<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Models\Users\EmailVerification;

class SendEmailVerification
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
     * @param  \App\Events\Models\Users\EmailVerification  $event
     * @return void
     */
    public function handle(EmailVerification $event)
    {
        Mail::to($event->user)->send(new WelcomeMail($event->user));;
    }
}
