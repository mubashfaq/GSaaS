<?php

namespace Workdo\RestaurantMenu\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanyMenuEvent;
use Workdo\ProductService\Events\CreateCategory;
use Workdo\ProductService\Events\CreateProduct;
use Workdo\ProductService\Events\UpdateCategory;
use Workdo\ProductService\Events\UpdateProduct;
use Workdo\RestaurantMenu\Listeners\CompanyMenuListener;
use Workdo\RestaurantMenu\Listeners\CreateCategoryLis;
use Workdo\RestaurantMenu\Listeners\CreateProductLis;
use Workdo\RestaurantMenu\Listeners\UpdateCategoryLis;
use Workdo\RestaurantMenu\Listeners\UpdateProductLis;

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
        CreateCategory::class => [
            CreateCategoryLis::class,
        ],
        CreateProduct::class => [
            CreateProductLis::class,
        ],
        UpdateCategory::class => [
            UpdateCategoryLis::class,
        ],
        UpdateProduct::class => [
            UpdateProductLis::class,
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
