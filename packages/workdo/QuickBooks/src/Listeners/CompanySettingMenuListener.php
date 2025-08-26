<?php

namespace Workdo\QuickBooks\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'QuickBooks';
        $menu = $event->menu;
        $menu->add([
            'title' => 'QuickBooks Settings',
            'name' => 'quickbooks',
            'order' => 635,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'navigation' => 'quickbooks-sidenav',
            'module' => $module,
            'permission' => 'quickbooks manage'
        ]);
    }
}
