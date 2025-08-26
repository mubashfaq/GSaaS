<?php

namespace Workdo\Documents\Database\Seeders;

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
        $module = 'Documents';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'Documents';
        $data['product_main_description'] = '<p>Welcome to Documents Integration in Dash SaaS, your go-to solution for efficient document management. With this powerful integration, managing and organizing your documents becomes a breeze. Say goodbye to the clutter of multiple document storage systems and hello to a centralized hub for all your document needs.</p>';
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = 'Simplify Document Management';
        $data['dedicated_theme_description'] = '<p>Effortlessly organize and access documents in one place with Dash SaaS\'s Documents Integration, allowing easy attachment, commenting, and note-taking for enhanced collaboration</p>';
        $data['dedicated_theme_sections'] = '[
            {
                "dedicated_theme_section_image": "",
                "dedicated_theme_section_heading": "Streamlined project document management",
                "dedicated_theme_section_description": "",
                "dedicated_theme_section_cards": {
                    "1": {
                        "title": "Seamless Communication with Comments:",
                        "description": "Another valuable feature of Documents Integration is the ability to add comments to your documents. Share feedback, ask questions, or provide updates directly within the document interface, facilitating seamless communication among team members. With comments, you can ensure that everyone stays on the same page and collaborates effectively."
                    },
                    "2": {
                        "title": "Adding Context with Notes:",
                        "description": "Documents Integration also allows you to add notes to your documents, providing additional context and insights as needed. Whether it\'s important reminders, key points, or additional information, you can include notes directly within the document interface for easy reference. Enhance the usability and clarity of your documents with the ability to add notes as needed."
                    }
                }
            },
            {
                "dedicated_theme_section_image": "",
                "dedicated_theme_section_heading": "Seamlessly Integrate Documents Integration with the Project Module",
                "dedicated_theme_section_description": "<p>Experience the seamless integration of Dash SaaS\'s Documents Integration with the Project Module, revolutionizing project document management. Effortlessly link project-related documents, streamline collaboration, and enhance transparency within your project teams. With centralized document organization and project-centric features, empower your teams to achieve greater productivity and efficiency in project execution.</p>",
                "dedicated_theme_section_cards": {
                    "1": {
                        "title": null,
                        "description": null
                    }
                }
            },
            {
                "dedicated_theme_section_image": "",
                "dedicated_theme_section_heading": "Enhanced Collaboration with Attachments:",
                "dedicated_theme_section_description": "<p>One of the standout features of Documents Integration is its ability to add various attachments to your documents. Whether you need to include additional files, images, or multimedia content, you can easily attach them to your documents for enhanced context and collaboration. Foster greater collaboration among team members by providing all the necessary information in one place.</p>",
                "dedicated_theme_section_cards": {
                    "1": {
                        "title": null,
                        "description": null
                    }
                }
            }
        ]';
        $data['dedicated_theme_sections_heading'] = '';
        $data['screenshots'] = '[{"screenshots":"","screenshots_heading":"Sales"},{"screenshots":"","screenshots_heading":"Sales"},{"screenshots":"","screenshots_heading":"Sales"},{"screenshots":"","screenshots_heading":"Sales"},{"screenshots":"","screenshots_heading":"Sales"}]';
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

        foreach ($data as $key => $value) {
            if (!MarketplacePageSetting::where('name', '=', $key)->where('module', '=', $module)->exists()) {
                MarketplacePageSetting::updateOrCreate(
                    [
                        'name' => $key,
                        'module' => $module

                    ],
                    [
                        'value' => $value
                    ]
                );
            }
        }
    }
}
