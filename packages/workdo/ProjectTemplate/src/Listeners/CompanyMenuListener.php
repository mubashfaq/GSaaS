<?php

namespace Workdo\ProjectTemplate\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {

        $module = 'ProjectTemplate';
        $menu = $event->menu;
        $menu->add([
            'category' => 'Finance',
            'title' => __('Project Template'),
            'icon' => '',
            'name' => 'project-template',
            'parent' => 'projects',
            'order' => 15,  
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'project-template.index',
            'module' => $module,
            'permission' => 'project template manage'
        ]);
    }
}
