<?php

namespace Workdo\FindGoogleLeads\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanyMenuEvent;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use Workdo\FindGoogleLeads\Listeners\CreateLeadLis;
use Workdo\FindGoogleLeads\Listeners\CompanyMenuListener;
use Workdo\FindGoogleLeads\Listeners\CompanySettingListener;
use Workdo\FindGoogleLeads\Listeners\CompanySettingMenuListener;
use Workdo\Lead\Events\CreateLead;

class EventServiceProvider extends Provider
{
    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    protected $listen = [
        CompanyMenuEvent::class => [
            CompanyMenuListener::class,
        ],
        CompanySettingEvent::class => [
            CompanySettingListener::class,
        ],
        CompanySettingMenuEvent::class => [
            CompanySettingMenuListener::class,
        ],
        CreateLead::class => [
            CreateLeadLis::class,
        ],
    ];

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        return [
            __DIR__ . '/../Listeners',
        ];
    }
}
