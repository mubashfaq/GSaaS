<?php

namespace Workdo\Retainer\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanyMenuEvent;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use App\Events\DefaultData;
use App\Events\GivePermissionToRole;
use Workdo\Retainer\Listeners\CompanyMenuListener;
use Workdo\Retainer\Listeners\CompanySettingListener;
use Workdo\Retainer\Listeners\CompanySettingMenuListener;
use Workdo\Retainer\Listeners\DataDefault;
use Workdo\Retainer\Listeners\GiveRoleToPermission;

class EventServiceProvider extends Provider
{
    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }

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
        DefaultData::class => [
            DataDefault::class
        ],
        GivePermissionToRole::class => [
            GiveRoleToPermission::class
        ]
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
