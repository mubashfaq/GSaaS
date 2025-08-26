<?php

namespace Workdo\QuickBooks\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Workdo\Commission\Entities\CommissionPlan;

class ViewComposer extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['account::chartOfAccount.index'], function ($view)
        {

            if(\Auth::check())
            {
                $company_settings = getCompanyAllSetting(creatorId(),getActiveWorkSpace());

                if(isset($company_settings['quickbook_is_on']) && $company_settings['quickbook_is_on'] == 'on' && !empty($company_settings['quickbook_client_id']) && !empty($company_settings['quickbook_client_secretkey']) && !empty($company_settings['quickbook_company_id']))
                {
                    $view->getFactory()->startPush('header_button', view('quick-books::chartofaccount.sync_button'));
                }
            }
        });
    }
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
