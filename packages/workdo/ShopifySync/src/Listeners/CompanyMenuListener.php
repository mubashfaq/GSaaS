<?php

namespace Workdo\ShopifySync\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'ShopifySync';
        $menu = $event->menu;
        $menu->add([
            'category' => 'eCommerce',
            'title' => __('Shopify'),
            'icon' => 'brand-skype',
            'name' => 'shopify',
            'parent' => null,
            'order' => 800,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'shopify manage'
        ]);
        $menu->add([
            'category' => 'eCommerce',
            'title' => __('Customer'),
            'icon' => '',
            'name' => 'customer',
            'parent' => 'shopify',
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'shopify-customer.index',
            'module' => $module,
            'permission' => 'shopify customer manage'
        ]);
        $menu->add([
            'category' => 'eCommerce',
            'title' => __('Product'),
            'icon' => '',
            'name' => 'product',
            'parent' => 'shopify',
            'order' => 15,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'shopify-product.index',
            'module' => $module,
            'permission' => 'shopify product manage'
        ]);
        $menu->add([
            'category' => 'eCommerce',
            'title' => __('Order'),
            'icon' => '',
            'name' => 'order',
            'parent' => 'shopify',
            'order' => 20,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'shopify-order.index',
            'module' => $module,
            'permission' => 'shopify order manage'
        ]);
        $menu->add([
            'category' => 'eCommerce',
            'title' => __('Category'),
            'icon' => '',
            'name' => 'category',
            'parent' => 'shopify',
            'order' => 25,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'shopify-category.index',
            'module' => $module,
            'permission' => 'shopify category manage'
        ]);
        $menu->add([
            'category' => 'eCommerce',
            'title' => __('Coupon'),
            'icon' => '',
            'name' => 'coupon',
            'parent' => 'shopify',
            'order' => 30,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'shopify-coupon.index',
            'module' => $module,
            'permission' => 'shopify coupon manage'
        ]);
    }
}
