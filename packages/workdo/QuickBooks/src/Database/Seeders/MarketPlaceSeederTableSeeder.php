<?php

namespace Workdo\QuickBooks\Database\Seeders;

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
        $module = 'QuickBooks';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'QuickBooks';
        $data['product_main_description'] = '<p>Integrating QuickBooks with Dash SaaS streamlines financial processes, offering users a seamless experience in managing their accounting and business operations. Users can synchronize data between Dash SaaS and QuickBooks through this integration, ensuring consistency and accuracy across both platforms.</p>';
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = 'Effortless Finance: QuickBooks Integration';
        $data['dedicated_theme_description'] = "<p>Experience effortless financial management with Dash SaaS's seamless integration with QuickBooks. Sync data effortlessly, gain real-time insights, and streamline operations for enhanced efficiency.</p>";
        $data['dedicated_theme_sections'] = '[{"dedicated_theme_section_image": "","dedicated_theme_section_heading": "Syncing Data Seamlessly with QuickBooks","dedicated_theme_section_description": "One of the primary benefits of QuickBooks integration in Dash SaaS is eliminating manual data entry tasks. Instead of manually transferring data between systems, users can automate the process, saving time and reducing the risk of errors. This automation extends to various financial transactions, including invoicing, and payment reconciliation, allowing businesses to maintain up-to-date and accurate financial records effortlessly."},{"dedicated_theme_section_image": "","dedicated_theme_section_heading": "Real-Time Insights: Enhancing Visibility through QuickBooks Integration","dedicated_theme_section_description": "Moreover, QuickBooks integration enhances visibility and transparency in financial performance. By synchronizing data between Dash SaaS and QuickBooks, users gain real-time insights into their financial metrics, such as revenue, expenses, and cash flow. This visibility enables informed decision-making, as stakeholders can assess the financial health of their business and identify areas for improvement more effectively."},{"dedicated_theme_section_image": "","dedicated_theme_section_heading": "Easy Synchronization of Invoice and Chart of Accounts ","dedicated_theme_section_description": "You can easily sync your invoices of Dash SaaS with Quickbooks if you add the required credentials in the settings of Dash SaaS. You just have to create an invoice and then you can easily sync it with QuickBooks. Similarly, you can also sync your chart of accounts with QuickBooks by following the same process"}]';
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
