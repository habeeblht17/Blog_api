<?php

namespace App\Subscribers\Models;

use Illuminate\Events\Dispatcher;
use App\Listeners\SendEmailVerification;
use App\Events\Models\Users\EmailVerification;

class UserSubscriber
{
    public function subscribe(Dispatcher $event) {

        $event->listen(EmailVerification::class, SendEmailVerification::class);

    }
}
