<?php

namespace Workdo\FindGoogleLeads\Database\Seeders;

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
        $module = 'FindGoogleLeads';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'Find Google Leads';
        $data['product_main_description'] = '<p>Introducing the Find Google Leads Module Integration in Dash SaaS, a game-changer in lead management. This latest feature empowers users to effortlessly handle Google leads by providing essential input fields such as API key, search radius, pipeline selection, and stage customization. By streamlining the lead management process, Dash SaaS eliminates the need for manual data entry and simplifies the task of identifying and tracking potential customers.</p>';
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = 'Google Lead Management Made Easy';
        $data['dedicated_theme_description'] = "<p>Simplify lead handling with Dash SaaS's Google Leads Module. Enter API keys, set search parameters, and seamlessly integrate leads into pipelines for efficient management.</p>";
        $data['dedicated_theme_sections'] = '[{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Effortless Lead Identification: Simplify Google Lead Management with Dash SaaS","dedicated_theme_section_description":"<p>With our integration, users can seamlessly manage leads by inputting their Google API key and setting the desired search radius. This automation feature saves valuable time and ensures that users can quickly identify leads within their target geographic area. By centralizing lead management within Dash SaaS, users can access and process Google leads alongside other lead sources, creating a unified and efficient workflow.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Seamless Integration: Google Leads Meet Dash SaaS Pipelines","dedicated_theme_section_description":"<p>Pipeline selection is made easy with Dash SaaS, allowing users to integrate Google leads into existing pipelines seamlessly. By choosing the appropriate pipeline for their leads, users can ensure that each lead progresses through the sales process efficiently. Moreover, users have the flexibility to customize lead stages to align with their unique workflow, from initial contact to conversion, enabling better tracking and management of leads.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Customized Workflow: Tailoring Lead Stages in Dash SaaS","dedicated_theme_section_description":"<p>The integration of the Find Google Leads Module enhances efficiency by providing a centralized platform for lead management. With all leads consolidated within Dash SaaS, users can focus their efforts on nurturing relationships and closing deals, rather than navigating multiple platforms. This consolidation not only saves time but also ensures consistency and accuracy in lead management practices.<\/p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}}]';
        $data['dedicated_theme_sections_heading'] = '';
        $data['screenshots'] = '[{"screenshots":"","screenshots_heading":"FindGoogleLeads"},{"screenshots":"","screenshots_heading":"FindGoogleLeads"},{"screenshots":"","screenshots_heading":"FindGoogleLeads"},{"screenshots":"","screenshots_heading":"FindGoogleLeads"},{"screenshots":"","screenshots_heading":"FindGoogleLeads"}]';
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
