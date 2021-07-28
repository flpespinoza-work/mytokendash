<?php

namespace App\Listeners;

use App\Events\SendNewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Traits\Notifications;

class NewNotificationListener
{
    use Notifications;

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
     * @param  SendNewNotification  $event
     * @return void
     */
    public function handle(SendNewNotification $event)
    {
        dd($event);
    }
}
