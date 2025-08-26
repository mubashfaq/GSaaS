<?php

namespace Workdo\ActivityLog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Workdo\ActivityLog\Entities\AllActivityLog;
use Workdo\CarDealership\Entities\CarSale;
use Workdo\CarDealership\Events\UpdateCarSale;

class UpdateCarSaleLis
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UpdateCarSale $event)
    {
        if (module_is_active('ActivityLog')) {
            $car_sale = $event->car_sale;
            
            $activity                   = new AllActivityLog();
            $activity['module']         = 'Car Dealership';
            $activity['sub_module']     = 'Car Sale';
            $activity['description']    =  __('Car Sale ') . CarSale::saleInvoiceNumberFormat($car_sale->sale_id) . __(' Updated by the ');
            $activity['user_id']        =  Auth::user()->id;
            $activity['url']            = '';
            $activity['workspace']      = $car_sale->workspace;
            $activity['created_by']     = $car_sale->created_by;
            $activity->save();
        }
    }
}
