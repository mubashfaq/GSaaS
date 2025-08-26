<?php

namespace Workdo\ShopifySync\Database\Seeders;

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
        $module = 'ShopifySync';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'Shopify Sync';
        $data['product_main_description'] = '<p>Streamline your operations and enhance customer experiences by simplifying the management of Shopify products, categories, customers, orders and coupons. Our integration solutions empower you to take your online sales to the next level.</p>';
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = '<h2>Simplify <b> Shopify</b> Integration</h2>';
        $data['dedicated_theme_description'] = '<p>Supercharge your online sales with Shopify integration by simplifying Shopify product, category, customer, order and coupon management.</p>';
        $data['dedicated_theme_sections'] = '[{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Effortless Product Management and Seamless Coupon Control","dedicated_theme_section_description":"<p>Simplify your Shopify store operations with user-friendly tools designed to streamline product and inventory management. Spend less time on administrative tasks and more time focusing on business growth. Take control of your discount strategy with our intuitive coupon management system.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Enhanced Customer Interaction","dedicated_theme_section_description":"<p>With Shopify user-friendly platform, you can foster meaningful relationships with your customers and provide them with an exceptional shopping experience. Elevate your customer service game by building stronger relationships through personalized interactions.You can also integrate the Category and Products easily with the help of this module.The fusion of Shopify empowers you to enhance customer interaction.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}}]';
        $data['dedicated_theme_sections_heading'] = '';
        $data['screenshots'] = '[{"screenshots":"","screenshots_heading":"Shopify Sync"},{"screenshots":"","screenshots_heading":"Shopify Sync"},{"screenshots":"","screenshots_heading":"Shopify Sync"},{"screenshots":"","screenshots_heading":"Shopify Sync"},{"screenshots":"","screenshots_heading":"Shopify Sync"}]';
        $data['addon_heading'] = '<h2>Why choose dedicated modules<b> for Your Business?</b></h2>';
        $data['addon_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location.</p>';
        $data['addon_section_status'] = 'on';
        $data['whychoose_heading'] = 'Why choose dedicated modulesfor Your Business?';
        $data['whychoose_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location.</p>';
        $data['pricing_plan_heading'] = 'Empower Your Workforce with DASH';
        $data['pricing_plan_description'] = '<p>Access over Premium Add-ons for Accounting, HR, Payments, Leads, Communication, Management, and more, all in one place!</p>';
        $data['pricing_plan_demo_link'] = '#';
        $data['pricing_plan_demo_button_text'] = 'View Live Demo';
        $data['pricing_plan_text'] = '{"1":{"title":"Pay-as-you-go"},"2":{"title":"Unlimited installation"},"3":{"title":"Secure cloud storage"}}';
        $data['whychoose_sections_status'] = 'on';
        $data['dedicated_theme_section_status'] = 'on';

        foreach($data as $key => $value){
            if(!MarketplacePageSetting::where('name', '=', $key)->where('module', '=', 'ShopifySync')->exists()){
                MarketplacePageSetting::updateOrCreate(
                [
                    'name' => $key,
                    'module' => 'ShopifySync'

                ],
                [
                    'value' => $value
                ]);
            }
        }
    }
}
