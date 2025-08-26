<?php

namespace Workdo\ShopifySync\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanyMenuEvent;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use Workdo\ProductService\Events\DestroyProduct;
use Workdo\ProductService\Events\DestroyCategory;
use Workdo\ShopifySync\Listeners\CompanyMenuListener;
use Workdo\ShopifySync\Listeners\CompanySettingListener;
use Workdo\ShopifySync\Listeners\CompanySettingMenuListener;
use Workdo\ShopifySync\Listeners\DestroyShopifycategory;
use Workdo\ShopifySync\Listeners\DestroyShopifyproduct;
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
        DestroyCategory::class => [
            DestroyShopifycategory::class,
        ],
        DestroyProduct::class => [
            DestroyShopifyproduct::class,
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
