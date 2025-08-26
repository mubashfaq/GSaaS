<?php

namespace Workdo\QuickBooks\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use App\Events\CompanyMenuEvent;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use App\Events\CreateInvoice;
use App\Events\CreatePaymentInvoice;
use App\Events\UpdateInvoice;
use Workdo\QuickBooks\Listeners\CompanyMenuListener;
use Workdo\QuickBooks\Listeners\CompanySettingListener;
use Workdo\QuickBooks\Listeners\CompanySettingMenuListener;
use Workdo\QuickBooks\Listeners\CreateInvoicePaymentLis;
use Workdo\QuickBooks\Listeners\CreateQuickBookLis;
use Workdo\QuickBooks\Listeners\UpdateQuickBookInvoiceLis;

class EventServiceProvider extends Provider
{
    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    protected $listen = [
       
        CompanySettingEvent::class => [
            CompanySettingListener::class,
        ],
        CompanySettingMenuEvent::class => [
            CompanySettingMenuListener::class,
        ],
        CreatePaymentInvoice::class => [
            CreateInvoicePaymentLis::class,
        ],
        CreateInvoice::class => [
            CreateQuickBookLis::class,
        ],
        UpdateInvoice::class => [
            UpdateQuickBookInvoiceLis::class,
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
