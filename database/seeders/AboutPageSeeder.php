<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Us',
                'subtitle' => 'Engineering Innovation for Practical Impact',
                'template' => 'about',
                'meta_title' => 'About VTLABS',
                'meta_description' => 'Learn about VTLABS, our mission, vision, engineering capabilities, team, achievements, and growth.',
                'is_published' => true,
                'sort_order' => 2,
            ]
        );

        $sections = [
            [
                'section_key' => 'about-hero',
                'title' => 'Engineering innovation for practical impact.',
                'subtitle' => 'About Our Company',
                'content' => 'We connect engineering knowledge, digital fabrication, manufacturing, software, consulting, and practical education to help ideas become useful solutions.',
                'layout' => 'hero',
                'data' => [
                    'primary_button_text' => 'Explore Our Services',
                    'primary_button_url' => '/services',
                    'secondary_button_text' => 'Start a Project',
                    'secondary_button_url' => '/contact',
                ],
                'sort_order' => 10,
            ],
            [
                'section_key' => 'company-story',
                'title' => 'Built to close the gap between ideas and implementation.',
                'subtitle' => 'Our Story',
                'content' => 'VTLABS was established to create an environment where ideas can be designed, tested, manufactured, improved, and transformed into practical products and systems. We work with individuals, students, institutions, businesses, and industries that need technical expertise and implementation support.',
                'layout' => 'split',
                'data' => [
                    'highlight_title' => 'One Innovation Ecosystem',
                    'highlight_text' => 'Design, engineering, manufacturing, technology, and training under one platform.',
                ],
                'sort_order' => 20,
            ],
            [
                'section_key' => 'mission-vision',
                'title' => 'Purpose that guides every project.',
                'subtitle' => 'Mission & Vision',
                'content' => 'Our direction is shaped by practical innovation, local capability development, and long-term technical impact.',
                'layout' => 'cards',
                'data' => [
                    'mission_title' => 'Our Mission',
                    'mission_text' => 'To provide accessible engineering, manufacturing, technology, and practical training solutions that transform ideas into useful products, systems, and skills.',
                    'vision_title' => 'Our Vision',
                    'vision_text' => 'To become a leading innovation and technical development laboratory supporting industrial growth, entrepreneurship, education, and technological progress.',
                ],
                'sort_order' => 30,
            ],
            [
                'section_key' => 'core-values',
                'title' => 'The principles behind our work.',
                'subtitle' => 'Core Values',
                'content' => 'Every solution is developed around quality, practicality, learning, responsibility, and measurable value.',
                'layout' => 'grid',
                'data' => [
                    'items' => [
                        [
                            'title' => 'Innovation',
                            'description' => 'We explore better approaches and transform creative ideas into functional solutions.',
                        ],
                        [
                            'title' => 'Practicality',
                            'description' => 'We focus on solutions that can work in real environments and solve real problems.',
                        ],
                        [
                            'title' => 'Quality',
                            'description' => 'We apply care, accuracy, testing, and continuous improvement throughout our work.',
                        ],
                        [
                            'title' => 'Collaboration',
                            'description' => 'We build stronger results by working closely with clients, learners, partners, and communities.',
                        ],
                        [
                            'title' => 'Learning',
                            'description' => 'We share technical knowledge and support the development of future innovators.',
                        ],
                        [
                            'title' => 'Responsibility',
                            'description' => 'We respect our commitments and consider the long-term impact of every solution.',
                        ],
                    ],
                ],
                'sort_order' => 40,
            ],
            [
                'section_key' => 'team',
                'title' => 'The people behind the innovation.',
                'subtitle' => 'Our Team',
                'content' => 'Our multidisciplinary team combines engineering, fabrication, software, training, research, and project-management capabilities.',
                'layout' => 'grid',
                'sort_order' => 50,
            ],
            [
                'section_key' => 'achievements',
                'title' => 'Progress measured through capability and impact.',
                'subtitle' => 'Achievements',
                'content' => 'Our growth is reflected in the solutions delivered, people trained, partnerships developed, and technical capabilities established.',
                'layout' => 'stats',
                'data' => [
                    'items' => [
                        [
                            'value' => '10',
                            'suffix' => '+',
                            'label' => 'Technical Capabilities',
                        ],
                        [
                            'value' => '50',
                            'suffix' => '+',
                            'label' => 'Projects Supported',
                        ],
                        [
                            'value' => '100',
                            'suffix' => '+',
                            'label' => 'Learners Reached',
                        ],
                        [
                            'value' => '360',
                            'suffix' => '°',
                            'label' => 'Development Support',
                        ],
                    ],
                ],
                'sort_order' => 60,
            ],
            [
                'section_key' => 'timeline',
                'title' => 'A growing platform for engineering and innovation.',
                'subtitle' => 'Our Journey',
                'content' => 'Each stage strengthens our ability to serve more innovators, institutions, businesses, and industries.',
                'layout' => 'timeline',
                'data' => [
                    'items' => [
                        [
                            'year' => 'Foundation',
                            'title' => 'The idea takes shape',
                            'description' => 'VTLABS begins as a platform connecting technical knowledge with practical implementation.',
                        ],
                        [
                            'year' => 'Expansion',
                            'title' => 'Capabilities grow',
                            'description' => 'Manufacturing, electronics, digital fabrication, software, and consulting services are expanded.',
                        ],
                        [
                            'year' => 'Academy',
                            'title' => 'Practical training launches',
                            'description' => 'Hands-on technical learning becomes an important part of the VTLABS ecosystem.',
                        ],
                        [
                            'year' => 'Future',
                            'title' => 'Building industrial impact',
                            'description' => 'The laboratory continues developing partnerships, products, research, and production capabilities.',
                        ],
                    ],
                ],
                'sort_order' => 70,
            ],
            [
                'section_key' => 'about-cta',
                'title' => 'Let’s create something practical, valuable, and built to last.',
                'subtitle' => 'Work With Us',
                'content' => 'Whether you need product development, manufacturing, technical consulting, laboratory setup, software, or training, our team is ready to understand your goals.',
                'layout' => 'cta',
                'data' => [
                    'button_text' => 'Discuss Your Project',
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
                    'layout' => $section['layout'],
                    'data' => $section['data'] ?? null,
                    'sort_order' => $section['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
