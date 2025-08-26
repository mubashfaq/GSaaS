<?php

namespace Workdo\Documents\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'Documents';
        $menu = $event->menu;
        $menu->add([
            'title' => 'Documents Settings',
            'name' => 'documents-settings',
            'order' => 357,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'navigation' => 'documents-sidenav',
            'module' => $module,
            'permission' => 'documents manage'
        ]);
    }
}
