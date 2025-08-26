<?php

namespace Workdo\VCard\Providers;

use App\Events\DefaultData;
use App\Events\GivePermissionToRole;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanyMenuEvent;
use Workdo\VCard\Listeners\DataDefault;
use Workdo\VCard\Listeners\GiveRoleToPermission;
use Workdo\VCard\Listeners\CompanyMenuListener;

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
        DefaultData::class => [
            DataDefault::class,
        ],
        GivePermissionToRole::class => [
            GiveRoleToPermission::class,
        ],
    ];

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */

    public function shouldDiscoverEvents()
    {
        return true;
    }

    protected function discoverEventsWithin()
    {
        return [
            __DIR__ . '/../Listeners',
        ];
    }
}
