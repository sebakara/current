<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class ManufacturingPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'manufacturing'],
            [
                'title' => 'Manufacturing',
                'subtitle' => 'From Concept to Production',
                'template' => 'manufacturing',
                'meta_title' => 'Manufacturing & Digital Fabrication',
                'meta_description' => 'Explore product development, prototyping, machining, PCB production, 3D printing, laser cutting, and manufacturing support.',
                'is_published' => true,
                'sort_order' => 4,
            ]
        );

        $sections = [
            [
                'section_key' => 'manufacturing-hero',
                'title' => 'From concept to production-ready solutions.',
                'subtitle' => 'Manufacturing & Fabrication',
                'content' => 'We combine engineering, prototyping, digital fabrication, electronics, and production support to help clients transform ideas into functional products.',
                'layout' => 'hero',
                'data' => [
                    'primary_button_text' => 'Start a Manufacturing Project',
                    'primary_button_url' => '/contact',
                    'secondary_button_text' => 'Explore Our Services',
                    'secondary_button_url' => '/services',
                ],
                'sort_order' => 10,
            ],
            [
                'section_key' => 'manufacturing-intro',
                'title' => 'Integrated manufacturing support for every development stage.',
                'subtitle' => 'What We Manufacture',
                'content' => 'Our capabilities support early prototypes, customized technical parts, electronic products, enclosures, mechanical components, demonstration models, and production preparation.',
                'layout' => 'split',
                'sort_order' => 20,
            ],
            [
                'section_key' => 'manufacturing-capabilities',
                'title' => 'Modern tools for practical production.',
                'subtitle' => 'Core Capabilities',
                'content' => 'We select the appropriate manufacturing method according to the material, precision, quantity, timeline, and intended use.',
                'layout' => 'grid',
                'data' => [
                    'items' => [
                        [
                            'title' => '3D Printing',
                            'description' => 'Rapid production of prototypes, models, components, and customized parts.',
                        ],
                        [
                            'title' => 'Laser Cutting',
                            'description' => 'Precision cutting and engraving for acrylic, wood, sheet materials, and prototypes.',
                        ],
                        [
                            'title' => 'PCB Production',
                            'description' => 'Circuit-board design, prototyping, assembly support, and testing.',
                        ],
                        [
                            'title' => 'CNC & Machining',
                            'description' => 'Precision manufacturing support for mechanical and industrial components.',
                        ],
                        [
                            'title' => 'Product Assembly',
                            'description' => 'Integration of mechanical, electronic, and enclosure components.',
                        ],
                        [
                            'title' => 'Production Consulting',
                            'description' => 'Material selection, process planning, cost review, and production preparation.',
                        ],
                    ],
                ],
                'sort_order' => 30,
            ],
            [
                'section_key' => 'manufacturing-process',
                'title' => 'A structured path from idea to finished product.',
                'subtitle' => 'Our Process',
                'content' => 'Every manufacturing project follows a practical workflow designed to reduce uncertainty, improve quality, and support reliable delivery.',
                'layout' => 'process',
                'data' => [
                    'items' => [
                        [
                            'number' => '01',
                            'title' => 'Requirements',
                            'description' => 'We understand the product, function, quantities, materials, timeline, and intended environment.',
                        ],
                        [
                            'number' => '02',
                            'title' => 'Design Review',
                            'description' => 'Technical drawings, models, schematics, and production requirements are reviewed.',
                        ],
                        [
                            'number' => '03',
                            'title' => 'Prototype',
                            'description' => 'A test version is produced to validate dimensions, function, fit, and usability.',
                        ],
                        [
                            'number' => '04',
                            'title' => 'Testing',
                            'description' => 'The prototype is evaluated and improvements are introduced where necessary.',
                        ],
                        [
                            'number' => '05',
                            'title' => 'Production',
                            'description' => 'Approved designs move into final fabrication, assembly, and quality checks.',
                        ],
                    ],
                ],
                'sort_order' => 40,
            ],
            [
                'section_key' => 'manufacturing-industries',
                'title' => 'Manufacturing support across multiple sectors.',
                'subtitle' => 'Industries We Serve',
                'content' => 'Our flexible technical capabilities allow us to support institutions, innovators, startups, businesses, and industrial operators.',
                'layout' => 'grid',
                'data' => [
                    'items' => [
                        'Education & Research',
                        'Electronics & IoT',
                        'Agriculture',
                        'Construction',
                        'Furniture & Interiors',
                        'Healthcare Technology',
                        'Renewable Energy',
                        'Industrial Operations',
                    ],
                ],
                'sort_order' => 50,
            ],
            [
                'section_key' => 'manufacturing-cta',
                'title' => 'Ready to manufacture your next idea?',
                'subtitle' => 'Start Production',
                'content' => 'Send us your concept, technical drawing, sample, specification, or problem statement. Our team will review the most suitable development and production approach.',
                'layout' => 'cta',
                'data' => [
                    'button_text' => 'Request Manufacturing Support',
                    'button_url' => '/contact',
                ],
                'sort_order' => 90,
            ],
        ];

        foreach ($sections as $section) {
            PageSection::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'section_key' => $section['section_key'],
                ],
                [
                    'title' => $section['title'],
                    'subtitle' => $section['subtitle'],
                    'content' => $section['content'],
                    'image' => $section['image'] ?? null,
                    'layout' => $section['layout'],
                    'data' => $section['data'] ?? null,
                    'sort_order' => $section['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
