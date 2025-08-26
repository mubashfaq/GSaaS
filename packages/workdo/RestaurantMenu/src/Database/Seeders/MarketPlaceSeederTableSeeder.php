<?php

namespace Workdo\RestaurantMenu\Database\Seeders;

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
        $module = 'RestaurantMenu';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'RestaurantMenu';
        $data['product_main_description'] = '<p>Effortlessly manage your restaurant`s menu with Dash SaaS. Our intuitive interface allows you to create, edit, and organize menu items with ease. Whether you`re updating prices, and descriptions, or adding new dishes, everything can be done in just a few clicks. Say goodbye to difficult menu management processes and hello to an effortless experience that saves you time and effort.</p>';
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = 'Dynamic Offers and Promotions';
        $data['dedicated_theme_description'] = '<p>Boost your sales and attract more customers with our offers management feature. With Dash SaaS, creating and managing special promotions has never been easier. From happy hour deals to seasonal discounts, you can set up and customize offers to suit your restaurant`s needs. Watch as your promotions drive traffic and increase revenue, all from within the convenience of our platform.</p>';
        $data['dedicated_theme_sections'] = '[{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Efficient Table Arrangements:","dedicated_theme_section_description":"<p>Optimize your dining space and streamline your operations with our table arrangement feature. Easily set up and modify table layouts, assign reservations, and keep track of available seating. With Dash SaaS, managing your restaurant`s floor plan has never been easier, allowing you to maximize efficiency and provide a seamless dining experience for your guests.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Customization and Real-time Updates:","dedicated_theme_section_description":"<p>Tailor your menu to fit your restaurant`s unique identity with our attribute and category creation tools. Whether you`re creating tags like spicy or vegetarian or organizing items into categories like appetizers and desserts, you have complete control over how your menu is presented. Plus, with instant front-end updates, any changes you make are immediately visible to your customers, ensuring that they always have access to the most current information.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Real-time Frontend Updates:","dedicated_theme_section_description":"<p>With Dash SaaS, any changes you make to your menu offers, or dining table arrangements are instantly visible on the front end. Whether you`re updating prices, creating new offers, or adjusting dining table layouts, your customers will always have access to the most up-to-date information. Say goodbye to manual updates and hello to a seamlessly integrated experience for both you and your customers.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}}]';
        $data['dedicated_theme_sections_heading'] = '';
        $data['screenshots'] = '[{"screenshots":"","screenshots_heading":"RestaurantMenu"},{"screenshots":"","screenshots_heading":"RestaurantMenu"},{"screenshots":"","screenshots_heading":"RestaurantMenu"},{"screenshots":"","screenshots_heading":"RestaurantMenu"}]';
        $data['addon_heading'] = 'Why choose dedicated modulesfor Your Business?';
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
