<?php

namespace Workdo\RestaurantMenu\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'RestaurantMenu';

        $menu = $event->menu;
        $menu->add([
            'category' => 'Operations',
            'title' => __('Restaurant'),
            'icon' => 'ti ti-tools-kitchen-2',
            'name' => 'restaurant',
            'parent' => null,
            'order' => 702,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'restaurant manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Items'),
            'icon' => '',
            'name' => 'items',
            'parent' => 'restaurant',
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'restaurant-items.index',
            'module' => $module,
            'permission' => 'item manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Customer'),
            'icon' => '',
            'name' => 'customer',
            'parent' => 'restaurant',
            'order' => 20,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'restaurant-customer.index',
            'module' => $module,
            'permission' => 'restaurant_customer manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Dining Table'),
            'icon' => '',
            'name' => 'dining-table',
            'parent' => 'restaurant',
            'order' => 25,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'restaurant-dining-table.index',
            'module' => $module,
            'permission' => 'dining_table manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Table Orders'),
            'icon' => '',
            'name' => 'table-order',
            'parent' => 'restaurant',
            'order' => 30,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'restaurant-order.index',
            'module' => $module,
            'permission' => 'restaurant_order manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Offers'),
            'icon' => '',
            'name' => 'table-offers',
            'parent' => 'restaurant',
            'order' => 35,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'restaurant-offers.index',
            'module' => $module,
            'permission' => 'offers manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('System Setup'),
            'icon' => '',
            'name' => 'restaurant-system-setup',
            'parent' => 'restaurant',
            'order' => 35,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'restaurant-items-attribute.index',
            'module' => $module,
            'permission' => 'restaurant_system manage'
        ]);
    }
}
