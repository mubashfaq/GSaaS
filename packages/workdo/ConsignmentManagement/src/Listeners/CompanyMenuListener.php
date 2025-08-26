<?php

namespace Workdo\ConsignmentManagement\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'ConsignmentManagement';
        $menu = $event->menu;
        $menu->add([
            'category' => 'Sales',
            'title' => __('Consignment'),
            'icon' => 'ti ti-truck-delivery',
            'name' => 'consignmentmanagement',
            'parent' => null,
            'order' => 707,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'consignment manage'
        ]);
        $menu->add([
            'category' => 'Sales',
            'title' => __('Product'),
            'icon' => '',
            'name' => 'product',
            'parent' => 'consignmentmanagement',
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'product.index',
            'module' => $module,
            'permission' => 'consignment product manage'
        ]);
        $menu->add([
            'category' => 'Sales',
            'title' => __('Consignment'),
            'icon' => '',
            'name' => 'consignment',
            'parent' => 'consignmentmanagement',
            'order' => 15,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'consignment.index',
            'module' => $module,
            'permission' => 'consignment manage'
        ]);
        $menu->add([
            'category' => 'Sales',
            'title' => __('Purchase Order'),
            'icon' => '',
            'name' => 'purchaseorder',
            'parent' => 'consignmentmanagement',
            'order' => 20,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'purchase-order.index',
            'module' => $module,
            'permission' => 'purchase order manage'
        ]);
        $menu->add([
            'category' => 'Sales',
            'title' => __('Sale Order'),
            'icon' => '',
            'name' => 'saleorder',
            'parent' => 'consignmentmanagement',
            'order' => 25,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'sale-order.index',
            'module' => $module,
            'permission' => 'sale order manage'
        ]);
        $menu->add([
            'category' => 'Sales',
            'title' => __('Shipping'),
            'icon' => '',
            'name' => 'consignmentshipping',
            'parent' => 'consignmentmanagement',
            'order' => 30,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'consignment-shipping.index',
            'module' => $module,
            'permission' => 'consignment shipping manage'
        ]);
        $menu->add([
            'category' => 'Sales',
            'title' => __('Returns'),
            'icon' => '',
            'name' => 'consignmentreturns',
            'parent' => 'consignmentmanagement',
            'order' => 35,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'consignment-return.index',
            'module' => $module,
            'permission' => 'consignment return manage'
        ]);

        $menu->add([
            'category' => 'Sales',
            'title' => __('Quality Control'),
            'icon' => '',
            'name' => 'consignmentqualitycontrol',
            'parent' => 'consignmentmanagement',
            'order' => 35,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'consignment-qualitycontrol.index',
            'module' => $module,
            'permission' => 'consignment return manage'
        ]);
        $menu->add([
            'category' => 'Sales',
            'title' => __('Contract'),
            'icon' => '',
            'name' => 'consignment-contract',
            'parent' => 'consignmentmanagement',
            'order' => 40,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'consignment-contract.index',
            'module' => $module,
            'permission' => 'consignment contract manage'
        ]);

        $menu->add([
            'category' => 'Sales',
            'title' => __('Compliance'),
            'icon' => '',
            'name' => 'consignment-compliance',
            'parent' => 'consignmentmanagement',
            'order' => 45,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'consignment-compliance.index',
            'module' => $module,
            'permission' => 'consignment compliance manage'
        ]);
    }
}
