<?php

namespace Workdo\ConsignmentManagement\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Workdo\LandingPage\Entities\MarketplacePageSetting;

class MarketPlaceSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $module = 'ConsignmentManagement';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'ConsignmentManagement';
        $data['product_main_description'] = '<p>The Consignment Module integration in Dash SaaS streamlines the creation and management of consignment agreements for businesses. Within the platform, users can easily generate customized consignment agreements tailored to their specific needs. These agreements can include detailed terms and conditions, pricing structures, commission rates, Tax calculation and inventory specifications. By providing a centralized platform for agreement creation, businesses can ensure consistency and accuracy across all their consignment partnerships, fostering stronger relationships with consignment partners and minimizing the risk of disputes.</p>';
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = 'Efficient Inventory Tracking and Management';
        $data['dedicated_theme_description'] = '<p>With the Consignment Module, businesses can efficiently track and manage consigned inventory within Dash SaaS.</p>';
        $data['dedicated_theme_sections'] = '[
                                                {
                                                    "dedicated_theme_section_image": "",
                                                    "dedicated_theme_section_heading": "Viewing and Pricing Products in Consignment",
                                                    "dedicated_theme_section_description": "<p>The Commission Module allows users to view a comprehensive list of products in consignment, ensuring complete visibility over inventory. Additionally, users can manage and update the pricing of these consigned products, which is essential for accurate commission calculations. This feature ensures that all commission-related transactions reflect the most current product prices, maintaining transparency and precision in payouts. You can also add the tax in your consignment while pricing.</p>",
                                                    "dedicated_theme_section_cards": {"1": {"title": null,"description": null}}
                                                },
                                                {
                                                    "dedicated_theme_section_image": "",
                                                    "dedicated_theme_section_heading": "Creating and Converting Purchase Orders",
                                                    "dedicated_theme_section_description": "<p>In the Commission Module, users can create detailed purchase orders and seamlessly convert these orders into actual purchases. This streamlined process ensures that procurement activities are efficiently managed and that all purchases are accurately recorded for commission calculations. By automating the conversion of purchase orders, the module reduces manual effort and enhances the accuracy of the procurement and commission tracking processes.</p>",
                                                    "dedicated_theme_section_cards": {"1": {"title": null,"description": null}}
                                                },
                                                {
                                                    "dedicated_theme_section_image": "",
                                                    "dedicated_theme_section_heading": "Creating and Converting Purchase Orders",
                                                    "dedicated_theme_section_description": "<p>The Commission Module also supports the creation of sale orders, which can be easily converted into finalized sales. This functionality is crucial for tracking sales performance and ensuring that commissions are calculated based on completed transactions. By automating the sale order conversion process, the module ensures timely and precise commission payouts, aligning sales</p>",
                                                    "dedicated_theme_section_cards": {"1": {"title": null,"description": null}}
                                                }
                                            ]';
        $data['dedicated_theme_sections_heading'] = '';
        $data['screenshots'] = '[{"screenshots":"","screenshots_heading":"ConsignmentManagement"},{"screenshots":"","screenshots_heading":"ConsignmentManagement"},{"screenshots":"","screenshots_heading":"ConsignmentManagement"},{"screenshots":"","screenshots_heading":"ConsignmentManagement"},{"screenshots":"","screenshots_heading":"ConsignmentManagement"}]';
        $data['addon_heading'] = 'Why choose dedicated modules for your business?';
        $data['addon_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location.</p>';
        $data['addon_section_status'] = 'on';
        $data['whychoose_heading'] = 'Why choose dedicated modules for your business?';
        $data['whychoose_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location.</p>';
        $data['pricing_plan_heading'] = 'Empower Your Workforce with DASH';
        $data['pricing_plan_description'] = '<p>Access over Premium Add-ons for Accounting, HR, Payments, Leads, Communication, Management, and more, all in one place!</p>';
        $data['pricing_plan_demo_link'] = '#';
        $data['pricing_plan_demo_button_text'] = 'View Live Demo';
        $data['pricing_plan_text'] = '{"1":{"title":"Pay-as-you-go"},"2":{"title":"Unlimited installation"},"3":{"title":"Secure cloud storage"}}';
        $data['whychoose_sections_status'] = 'on';
        $data['dedicated_theme_section_status'] = 'on';

        foreach ($data as $key => $value) {
            if (!MarketplacePageSetting::where('name', '=', $key)->where('module', '=', $module)->exists()) {
                MarketplacePageSetting::updateOrCreate(
                    [
                        'name' => $key,
                        'module' => $module,

                    ],
                    [
                        'value' => $value,
                    ]);
            }
        }
    }
}
