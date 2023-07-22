<?php

namespace App\Listeners;

use App\Events\NewPushNotificationEvent;
use App\Services\PushNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PushNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewPushNotificationEvent $event): void
    {
        $title = $event->title;
        $message = $event->message;
        $claimid = $event->claimid;
        try{
            $notification = new PushNotification();
            $notification->sendPushNotification($title, $message, $claimid);
        }catch(Exception $e){
            Log::error('UNABLE TO SEND NOTIFICATION  => '. $e->getMessage());
        }
    }
}
