<?php

namespace Workdo\FindGoogleLeads\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'FindGoogleLeads';
        $menu = $event->menu;
        $menu->add([
            'category' => 'Sales',
            'title' => __('Find Google Leads'),
            'icon' => 'search',
            'name' => 'findgoogleleads',
            'parent' => null,
            'order' => 1090,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'find-google-leads.index',
            'module' => $module,
            'permission' => 'findgooglelead manage'
        ]);
    }
}
