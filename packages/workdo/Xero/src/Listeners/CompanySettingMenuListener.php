<?php

namespace Workdo\Xero\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'Xero';
        $menu = $event->menu;
        $menu->add([
            'title' => 'Xero Settings',
            'name' => 'xero',
            'order' => 637,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'navigation' => 'xero-sidenav',
            'module' => $module,
            'permission' => 'xero manage'
        ]);
    }
}
