<?php

namespace Workdo\Xero\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
        $module = 'Xero';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'Xero';
        $data['product_main_description'] = "<p>Experience a new level of financial efficiency with Dash SaaS's seamless integration with Xero. By combining the powerful capabilities of Dash SaaS with the comprehensive accounting features of Xero, users can streamline their financial processes and gain greater control over their business operations.</p>";
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = 'Seamless Finance: Xero Integration';
        $data['dedicated_theme_description'] = "<p>Streamline financial management with Dash SaaS and Xero integration, empowering real-time insights and seamless operations for your business.</p>";
        $data['dedicated_theme_sections'] = '[{"dedicated_theme_section_image": "","dedicated_theme_section_heading": "Effortless Data Syncing with Xero","dedicated_theme_section_description": "Gone are the days of manual data entry and tedious reconciliation tasks. With Xero integration in Dash SaaS, users can effortlessly synchronize their financial data between both platforms. Whether it invoicing, expense tracking, or bank reconciliation, the integration ensures that all data is consistently up-to-date and accurate, saving valuable time and minimizing the risk of errors."},{"dedicated_theme_section_image": "","dedicated_theme_section_heading": "Real-Time Visibility: Empowering Informed Decision-Making","dedicated_theme_section_description": "The integration of Xero with Dash SaaS provides users with unparalleled visibility into their financial performance. By syncing data in real-time, users can access up-to-the-minute insights into key metrics such as revenue, expenses, and cash flow. This level of visibility empowers stakeholders to make informed decisions, identify trends, and proactively manage their finances for long-term success."},{"dedicated_theme_section_image": "","dedicated_theme_section_heading": "Simple synchronization of invoices and charts of accounts in Dash SaaS with Xero","dedicated_theme_section_description": "You may quickly sync your Dash SaaS invoices with Xero provided you enter the necessary credentials in Dash SaaS settings. Simply create an invoice and then sync it with Xero. Similarly, you may sync your chart of accounts with Xero by following the same steps."}]';
        $data['dedicated_theme_sections_heading'] = '';
        $data['screenshots'] = '[{"screenshots":"","screenshots_heading":"QuickBooks"},{"screenshots":"","screenshots_heading":"QuickBooks"},{"screenshots":"","screenshots_heading":"QuickBooks"},{"screenshots":"","screenshots_heading":"QuickBooks"},{"screenshots":"","screenshots_heading":"QuickBooks"}]';
        $data['addon_heading'] = 'Why choose dedicated modulesfor Your Business?';
        $data['addon_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location.</p>';
        $data['addon_section_status'] = 'on';
        $data['whychoose_heading'] = 'Why choose dedicated modulesfor Your Business?';
        $data['whychoose_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location</p>';
        $data['pricing_plan_heading'] = 'Empower Your Workforce with DASH';
        $data['pricing_plan_description'] = '<p>Access over Premium Add-ons for Accounting, HR, Payments, Leads, Communication, Management, and more, all in one place!</p>';
        $data['pricing_plan_demo_link'] = '#';
        $data['pricing_plan_demo_button_text'] = 'View Live Demo';
        $data['pricing_plan_text'] = '{"1":{"title":"Pay-as-you-go"},"2":{"title":"Unlimited installation"},"3":{"title":"Secure cloud storage"}}';
        $data['whychoose_sections_status'] = 'on';
        $data['dedicated_theme_section_status'] = 'on';

        foreach($data as $key => $value){
            if(!MarketplacePageSetting::where('name', '=', $key)->where('module', '=', $module)->exists()){
                MarketplacePageSetting::updateOrCreate(
                    [
                        'name' => $key,
                        'module' => $module

                    ],
                    [
                        'value' => $value
                    ]);
            }
        }
    }
}
