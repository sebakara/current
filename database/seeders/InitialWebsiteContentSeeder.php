<?php

namespace Database\Seeders;

use App\Models\FooterLink;
use App\Models\FooterSection;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class InitialWebsiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'identity', 'key' => 'company_name', 'value' => 'VTLABS'],
            ['group' => 'identity', 'key' => 'company_short_name', 'value' => 'VT'],
            ['group' => 'identity', 'key' => 'company_tagline', 'value' => 'Innovation Laboratory'],
            ['group' => 'identity', 'key' => 'logo', 'value' => null, 'type' => 'image'],
            ['group' => 'identity', 'key' => 'favicon', 'value' => null, 'type' => 'image'],

            ['group' => 'contact', 'key' => 'company_email', 'value' => 'info@vtlabs.com'],
            ['group' => 'contact', 'key' => 'company_phone', 'value' => '+250 000 000 000'],
            ['group' => 'contact', 'key' => 'company_address', 'value' => 'Kigali, Rwanda'],

            ['group' => 'footer', 'key' => 'footer_description', 'value' => 'Engineering, manufacturing, technology, and practical training solutions.'],
            ['group' => 'footer', 'key' => 'copyright_text', 'value' => 'All rights reserved.'],

            ['group' => 'seo', 'key' => 'default_meta_title', 'value' => 'Innovation, Manufacturing & Technology'],
            ['group' => 'seo', 'key' => 'default_meta_description', 'value' => 'Engineering, manufacturing, digital fabrication, software, and technical training solutions.'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'group' => $setting['group'],
                    'value' => $setting['value'],
                    'type' => $setting['type'] ?? 'text',
                    'is_public' => true,
                ]
            );
        }

        $headerMenu = Menu::updateOrCreate(
            ['location' => 'header'],
            [
                'name' => 'Main Navigation',
                'is_active' => true,
            ]
        );

        $menuItems = [
            ['label' => 'Home', 'route_name' => 'home', 'sort_order' => 1],
            ['label' => 'About', 'route_name' => 'about', 'sort_order' => 2],
            ['label' => 'Services', 'route_name' => 'services.index', 'sort_order' => 3],
            ['label' => 'Manufacturing', 'route_name' => 'manufacturing', 'sort_order' => 4],
            ['label' => 'Products', 'route_name' => 'products', 'sort_order' => 5],
            ['label' => 'Projects', 'route_name' => 'projects', 'sort_order' => 6],
            ['label' => 'Academy', 'route_name' => 'academy', 'sort_order' => 7],
            ['label' => 'VTL Woods', 'route_name' => 'vtl-woods', 'sort_order' => 8],
            ['label' => 'Contact', 'route_name' => 'contact', 'sort_order' => 9],
        ];

        foreach ($menuItems as $item) {
            MenuItem::updateOrCreate(
                [
                    'menu_id' => $headerMenu->id,
                    'route_name' => $item['route_name'],
                ],
                [
                    'label' => $item['label'],
                    'sort_order' => $item['sort_order'],
                    'target' => '_self',
                    'is_active' => true,
                ]
            );
        }

        $exploreSection = FooterSection::updateOrCreate(
            ['section_key' => 'explore'],
            [
                'title' => 'Explore',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        foreach ([
            ['label' => 'About Us', 'route_name' => 'about', 'sort_order' => 1],
            ['label' => 'Our Services', 'route_name' => 'services.index', 'sort_order' => 2],
            ['label' => 'Manufacturing', 'route_name' => 'manufacturing', 'sort_order' => 3],
            ['label' => 'Projects', 'route_name' => 'projects', 'sort_order' => 4],
            ['label' => 'Training Academy', 'route_name' => 'academy', 'sort_order' => 5],
        ] as $link) {
            FooterLink::updateOrCreate(
                [
                    'footer_section_id' => $exploreSection->id,
                    'route_name' => $link['route_name'],
                ],
                [
                    'label' => $link['label'],
                    'sort_order' => $link['sort_order'],
                    'target' => '_self',
                    'is_active' => true,
                ]
            );
        }

        foreach ([
            ['platform' => 'LinkedIn', 'url' => '#', 'sort_order' => 1],
            ['platform' => 'Instagram', 'url' => '#', 'sort_order' => 2],
            ['platform' => 'YouTube', 'url' => '#', 'sort_order' => 3],
            ['platform' => 'Facebook', 'url' => '#', 'sort_order' => 4],
        ] as $social) {
            SocialLink::updateOrCreate(
                ['platform' => $social['platform']],
                [
                    'url' => $social['url'],
                    'sort_order' => $social['sort_order'],
                    'is_active' => false,
                ]
            );
        }

        $homePage = Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Home',
                'template' => 'home',
                'is_published' => true,
                'sort_order' => 1,
            ]
        );

        PageSection::updateOrCreate(
            [
                'page_id' => $homePage->id,
                'section_key' => 'about-preview',
            ],
            [
                'title' => 'One laboratory. Multiple engineering capabilities.',
                'subtitle' => 'About VTLABS',
                'content' => 'We help individuals, businesses, institutions, and industries move from concept to implementation.',
                'layout' => 'split',
                'data' => [
                    'button_text' => 'Learn More',
                    'button_url' => '/about',
                ],
                'sort_order' => 20,
                'is_active' => true,
            ]
        );

        PageSection::updateOrCreate(
            [
                'page_id' => $homePage->id,
                'section_key' => 'services',
            ],
            [
                'title' => 'Featured services',
                'subtitle' => 'What We Do',
                'content' => 'Explore selected VTLABS engineering and technology services.',
                'data' => [
                    'button_text' => 'View All Services',
                    'button_url' => '/services',
                ],
                'sort_order' => 30,
                'is_active' => true,
            ]
        );

        PageSection::updateOrCreate(
            [
                'page_id' => $homePage->id,
                'section_key' => 'project-cta',
            ],
            [
                'title' => 'Have an idea that needs engineering or technical expertise?',
                'subtitle' => 'Start a Project',
                'content' => 'Share your concept with VTLABS and let our team help you turn it into a practical solution.',
                'data' => [
                    'button_text' => 'Request a Consultation',
                    'button_url' => '/contact',
                ],
                'sort_order' => 90,
                'is_active' => true,
            ]
        );
    }
}
