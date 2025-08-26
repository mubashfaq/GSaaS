<?php

namespace Workdo\RestaurantMenu\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Workdo\RestaurantMenu\Entities\RestaurantCategory;

class ViewComposer extends ServiceProvider
{
    public function boot()
    {
        view()->composer(['product-service::category.create', 'product-service::category.edit', 'invoice.create', 'invoice.edit', 'invoice.index'], function ($view) {
            if (Auth::check() && module_is_active('RestaurantMenu')) {
                $view->getFactory()->startPush('account_type', view('restaurant-menu::invoice.account_type'));
                $view->getFactory()->startPush('items_image', view('restaurant-menu::items.image'));               
            }
        });
    }
}
