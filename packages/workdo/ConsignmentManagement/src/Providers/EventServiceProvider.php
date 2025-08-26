<?php

namespace Workdo\ConsignmentManagement\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanyMenuEvent;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use Workdo\ConsignmentManagement\Listeners\CompanyMenuListener;
use Workdo\ConsignmentManagement\Listeners\CreateProductLis;
use Workdo\ConsignmentManagement\Listeners\DestroyProductLis;
use Workdo\ConsignmentManagement\Listeners\UpdateProductLis;
use Workdo\ProductService\Events\CreateProduct;
use Workdo\ProductService\Events\DestroyProduct;
use Workdo\ProductService\Events\UpdateProduct;

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
        CreateProduct::class => [
            CreateProductLis::class,
        ],
        UpdateProduct::class => [
            UpdateProductLis::class,
        ],
        DestroyProduct::class => [
            DestroyProductLis::class,
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
