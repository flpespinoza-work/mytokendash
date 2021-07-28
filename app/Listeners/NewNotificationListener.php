<?php

namespace App\Listeners;

use App\Events\SendNewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewNotificationListener
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
     * @param  SendNewNotification  $event
     * @return void
     */
    public function handle(SendNewNotification $event)
    {
        //
    }
}
