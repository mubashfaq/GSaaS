<?php

namespace Workdo\ShopifySync\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'ShopifySync';
        $menu = $event->menu;
        $menu->add([
            'title' => __('Shopify Settings'),
            'name' => 'shopify settings',
            'order' => 620,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'navigation'=>'shopify_sidenav',
            'module' => $module,
            'permission' => 'shopify manage'
        ]);
    }
}
