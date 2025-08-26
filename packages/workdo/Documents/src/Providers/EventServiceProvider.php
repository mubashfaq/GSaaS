<?php

namespace Workdo\Documents\Providers;

use App\Events\CompanyMenuEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use App\Events\GivePermissionToRole;
use Workdo\Documents\Listeners\CompanyMenuListener;
use Workdo\Documents\Listeners\CompanySettingListener;
use Workdo\Documents\Listeners\CompanySettingMenuListener;
use Workdo\Documents\Listeners\GiveRoleToPermission;

class EventServiceProvider extends Provider
{
    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */

    protected $listen = [
        CompanyMenuEvent::class => [
            CompanyMenuListener::class
        ],
        CompanySettingEvent::class => [
            CompanySettingListener::class
        ],
        CompanySettingMenuEvent::class => [
            CompanySettingMenuListener::class
        ],
        GivePermissionToRole::class => [
            GiveRoleToPermission::class
        ],
    ];

    public function shouldDiscoverEvents()
    {
        return true;
    }

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
