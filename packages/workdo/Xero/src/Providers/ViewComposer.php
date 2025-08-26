<?php

namespace Workdo\Xero\Providers;

use Illuminate\Support\ServiceProvider;

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

                if(isset($company_settings['xero_is_on']) && $company_settings['xero_is_on'] == 'on' && !empty($company_settings['xero_client_id']) && !empty($company_settings['xero_client_secretkey']))
                {
                    $view->getFactory()->startPush('header_button', view('xero::chartofaccount.sync_button'));
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
