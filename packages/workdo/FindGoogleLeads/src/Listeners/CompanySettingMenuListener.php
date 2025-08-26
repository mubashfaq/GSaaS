<?php

namespace Workdo\FindGoogleLeads\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'FindGoogleLeads';
        $menu = $event->menu;
        $menu->add([
            'title' => __('Find Google Leads'),
            'name' => 'findgoogleleads-setting',
            'order' => 780,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'home',
            'navigation' => 'findgooglelead-sidenav',
            'module' => $module,
            'permission' => 'findgooglelead manage'
        ]);
    }
}