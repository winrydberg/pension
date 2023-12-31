<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ClaimFileUploaded;
use App\Events\NewClaimAudited;
use App\Events\IssueResolved;
use App\Events\NewIssueRaised;
use App\Events\ClaimDownloaded;
use App\Events\ClaimDeleted;
use App\Events\NewClaimRegistered;
use App\Events\NewPushNotificationEvent;

use App\Listeners\SaveClaimFileRecord;
use App\Listeners\ReadCustomerRecordToDB;
use App\Listeners\ClaimAuditListener;
use App\Listeners\IssueResolvedListener;
use App\Listeners\NewIssueListener;
use App\Listeners\ClaimDownloadListener;
use App\Listeners\ClaimDeleteListener;
use App\Listeners\PushNotificationListener;
use App\Listeners\EmailNotificationListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        NewPushNotificationEvent::class => [
            PushNotificationListener::class,
        ],

        NewClaimRegistered::class => [
            PushNotificationListener::class,
        ],

        ClaimFileUploaded::class => [
            SaveClaimFileRecord::class,
            ReadCustomerRecordToDB::class,
        ],

        NewClaimAudited::class => [
            ClaimAuditListener::class,
            EmailNotificationListener::class,
        ],

        NewIssueRaised::class => [
            NewIssueListener::class
        ],

        IssueResolved::class => [
            IssueResolvedListener::class
        ],

        ClaimDownloaded::class => [
            ClaimDownloadListener::class
        ],

        ClaimDeleted::class => [
            ClaimDeleteListener::class
        ]
        
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
