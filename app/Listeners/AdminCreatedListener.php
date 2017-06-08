<?php

namespace App\Listeners;

use App\Events\AdminCreated;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class AdminCreatedListener
{
    use Notifiable;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminCreated  $event
     * @return void
     */
    public function handle(AdminCreated $event)
    {
        Log::info('New admin created sucessfully');
        $event->getAdmin()->sendCreatedNotification();
    }
}
