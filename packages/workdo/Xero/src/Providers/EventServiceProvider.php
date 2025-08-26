<?php

namespace Workdo\Xero\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;

use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use App\Events\CreateInvoice;
use App\Events\CreatePaymentInvoice;
use App\Events\PaymentDestroyInvoice;

use Workdo\Xero\Listeners\CompanySettingListener;
use Workdo\Xero\Listeners\CompanySettingMenuListener;
use Workdo\Xero\Listeners\CreateInvoiceLis;
use Workdo\Xero\Listeners\PaymentInvoiceDel;
use Workdo\Xero\Listeners\PaymentInvoiceLis;

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
        CreateInvoice::class =>[
            CreateInvoiceLis::class,
        ],
        PaymentDestroyInvoice::class => [
            PaymentInvoiceDel::class,
        ],
        CreatePaymentInvoice::class => [
            PaymentInvoiceLis::class,
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
