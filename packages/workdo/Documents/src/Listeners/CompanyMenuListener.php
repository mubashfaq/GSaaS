<?php

namespace Workdo\Documents\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'Documents';
        $menu = $event->menu;
        $menu->add([
            'category' => 'Productivity',
            'title' => 'Documents',
            'icon' => 'file-text',
            'name' => 'documents',
            'parent' => null,
            'order' => 730,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'documents manage'
        ]);
        $menu->add([
            'category' => 'Productivity',
            'title' => __('Documents'),
            'icon' => '',
            'name' => 'document',
            'parent' => 'documents',
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'documents.index',
            'module' => $module,
            'permission' => 'documents manage'
        ]);
        $menu->add([
            'category' => 'Productivity',
            'title' => __('Document Type'),
            'icon' => '',
            'name' => 'history',
            'parent' => 'documents',
            'order' => 20,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'documents-type.index',
            'module' => $module,
            'permission' => 'documents type manage'
        ]);
    }
}
