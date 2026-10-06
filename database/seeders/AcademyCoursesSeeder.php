<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AcademyCoursesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Practical electronics, circuit design, PCB development, and embedded hardware.',
                'sort_order' => 10,
            ],
            [
                'name' => 'Digital Fabrication',
                'description' => '3D design, 3D printing, laser cutting, and rapid prototyping.',
                'sort_order' => 20,
            ],
            [
                'name' => 'Smart Systems',
                'description' => 'Embedded systems, IoT, sensors, automation, and connected technologies.',
                'sort_order' => 30,
            ],
            [
                'name' => 'Software Development',
                'description' => 'Practical web, mobile, backend, and information-system development.',
                'sort_order' => 40,
            ],
            [
                'name' => 'Innovation',
                'description' => 'Product design, prototyping, validation, entrepreneurship, and implementation.',
                'sort_order' => 50,
            ],
            [
                'name' => 'Industrial Engineering',
                'description' => 'Industrial automation, control systems, production, and applied engineering.',
                'sort_order' => 60,
            ],
        ];

        $categoryModels = [];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);

            $categoryModels[$slug] = CourseCategory::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => true,
                    'sort_order' => $category['sort_order'],
                ]
            );
        }

        $courses = [
            [
                'category_slug' => 'electronics',
                'title' => 'Electronics and PCB Design',
                'short_description' => 'Learn circuit design, PCB development, assembly, testing, and practical electronics troubleshooting.',
                'description' => <<<'TEXT'
This practical course introduces learners to electronic components, circuit behaviour, schematic design, printed circuit board development, assembly, and testing.

Learners work through guided exercises and complete a functional electronics project. The programme combines technical concepts with practical laboratory experience.
TEXT,
                'duration' => '8 Weeks',
                'delivery_mode' => 'In-person Practical Training',
                'schedule' => 'Morning, afternoon, or evening sessions',
                'location' => 'VTLABS Innovation Laboratory',
                'requirements' => <<<'TEXT'
Interest in electronics and practical technology
Basic mathematics and problem-solving ability
Commitment to attend practical sessions
No advanced electronics experience required
TEXT,
                'outcomes' => <<<'TEXT'
Understand common electronic components
Read and create electronic schematics
Design a printed circuit board
Assemble and test electronic circuits
Diagnose common circuit problems
Complete a functional electronics project
TEXT,
                'curriculum' => [
                    [
                        'title' => 'Electronic Components and Safety',
                        'description' => 'Introduction to resistors, capacitors, diodes, transistors, integrated circuits, tools, and laboratory safety.',
                    ],
                    [
                        'title' => 'Circuit Design',
                        'description' => 'Understanding circuit diagrams, voltage, current, resistance, and practical circuit calculations.',
                    ],
                    [
                        'title' => 'PCB Design',
                        'description' => 'Creating schematics, component footprints, board layouts, and production files.',
                    ],
                    [
                        'title' => 'Assembly and Soldering',
                        'description' => 'Practical soldering, component placement, inspection, and board assembly.',
                    ],
                    [
                        'title' => 'Testing and Final Project',
                        'description' => 'Testing circuits, troubleshooting faults, and completing a functional PCB project.',
                    ],
                ],
                'sort_order' => 10,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'digital-fabrication',
                'title' => '3D Design and Printing',
                'short_description' => 'Create professional 3D models and transform them into functional physical prototypes.',
                'description' => <<<'TEXT'
This course introduces computer-aided 3D design, model preparation, slicing, material selection, printer operation, and prototype finishing.

Learners develop practical models and complete a final product or prototype using additive manufacturing.
TEXT,
                'duration' => '6 Weeks',
                'delivery_mode' => 'Hands-on Training',
                'schedule' => 'Flexible weekday and weekend sessions',
                'location' => 'VTLABS Fabrication Laboratory',
                'requirements' => <<<'TEXT'
Basic computer skills
Interest in design and manufacturing
Ability to attend practical laboratory sessions
No previous 3D-design experience required
TEXT,
                'outcomes' => <<<'TEXT'
Create accurate 3D models
Prepare models for printing
Operate a 3D printer safely
Select suitable materials and print settings
Identify and correct common printing problems
Produce a completed prototype
TEXT,
                'curriculum' => [
                    [
                        'title' => 'Introduction to Digital Fabrication',
                        'description' => 'Understanding additive manufacturing, applications, machines, and materials.',
                    ],
                    [
                        'title' => '3D Modelling',
                        'description' => 'Creating parts, dimensions, assemblies, and production-ready models.',
                    ],
                    [
                        'title' => 'Slicing and Print Preparation',
                        'description' => 'Supports, layer height, infill, temperature, orientation, and file preparation.',
                    ],
                    [
                        'title' => 'Printer Operation',
                        'description' => 'Machine setup, calibration, material loading, monitoring, and maintenance.',
                    ],
                    [
                        'title' => 'Prototype Project',
                        'description' => 'Designing, printing, reviewing, and improving a final physical prototype.',
                    ],
                ],
                'sort_order' => 20,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'smart-systems',
                'title' => 'Embedded Systems and IoT',
                'short_description' => 'Build connected electronic systems using sensors, microcontrollers, communication technologies, and cloud platforms.',
                'description' => <<<'TEXT'
This programme teaches learners how to design and build embedded and Internet of Things systems.

The training covers microcontrollers, sensors, actuators, communication protocols, data collection, automation, and practical smart-system development.
TEXT,
                'duration' => '10 Weeks',
                'delivery_mode' => 'Hybrid Practical Training',
                'schedule' => 'Weekday and weekend options',
                'location' => 'VTLABS Innovation Laboratory',
                'requirements' => <<<'TEXT'
Basic computer literacy
Interest in electronics or programming
Commitment to complete practical assignments
Previous programming knowledge is helpful but not required
TEXT,
                'outcomes' => <<<'TEXT'
Program microcontrollers
Connect and read sensors
Control actuators and devices
Transmit data between connected systems
Develop a basic IoT dashboard
Build a complete smart-system project
TEXT,
                'curriculum' => [
                    [
                        'title' => 'Microcontroller Fundamentals',
                        'description' => 'Development boards, inputs, outputs, programming structure, and debugging.',
                    ],
                    [
                        'title' => 'Sensors and Actuators',
                        'description' => 'Reading environmental data and controlling motors, relays, displays, and other devices.',
                    ],
                    [
                        'title' => 'Connectivity',
                        'description' => 'Wi-Fi, Bluetooth, serial communication, APIs, and common IoT protocols.',
                    ],
                    [
                        'title' => 'Data and Dashboards',
                        'description' => 'Collecting, storing, displaying, and interpreting device data.',
                    ],
                    [
                        'title' => 'Final IoT Project',
                        'description' => 'Developing and presenting a complete connected monitoring or automation system.',
                    ],
                ],
                'sort_order' => 30,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'software-development',
                'title' => 'Practical Software Development',
                'short_description' => 'Develop modern software applications through structured, project-based learning.',
                'description' => <<<'TEXT'
This course teaches software-development foundations through practical implementation.

Learners study frontend development, backend systems, databases, application logic, version control, testing, deployment, and project development.
TEXT,
                'duration' => '12 Weeks',
                'delivery_mode' => 'In-person and Online',
                'schedule' => 'Morning, afternoon, and evening sessions',
                'location' => 'VTLABS Technology Academy',
                'requirements' => <<<'TEXT'
Basic computer skills
Access to a laptop
Interest in programming and problem solving
Commitment to practise outside classroom sessions
TEXT,
                'outcomes' => <<<'TEXT'
Build responsive user interfaces
Develop backend application functionality
Design and use relational databases
Work with version-control tools
Test and debug applications
Deploy a complete software project
TEXT,
                'curriculum' => [
                    [
                        'title' => 'Web Foundations',
                        'description' => 'HTML, CSS, responsive design, user interfaces, and accessibility.',
                    ],
                    [
                        'title' => 'Programming Fundamentals',
                        'description' => 'Variables, conditions, loops, functions, data structures, and application logic.',
                    ],
                    [
                        'title' => 'Backend Development',
                        'description' => 'Server-side programming, routing, validation, authentication, and APIs.',
                    ],
                    [
                        'title' => 'Databases',
                        'description' => 'Database design, SQL, relationships, queries, and data management.',
                    ],
                    [
                        'title' => 'Final Software Project',
                        'description' => 'Planning, developing, testing, deploying, and presenting a complete application.',
                    ],
                ],
                'sort_order' => 40,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'innovation',
                'title' => 'Product Development and Innovation',
                'short_description' => 'Move from problem identification to design, prototyping, testing, and product validation.',
                'description' => <<<'TEXT'
This project-based programme guides learners through the full product-development process.

Participants identify practical problems, research users, generate ideas, create designs, build prototypes, test solutions, and prepare products for implementation.
TEXT,
                'duration' => '8 Weeks',
                'delivery_mode' => 'Project-based Training',
                'schedule' => 'Flexible project sessions',
                'location' => 'VTLABS Innovation Laboratory',
                'requirements' => <<<'TEXT'
Interest in solving practical problems
Willingness to collaborate in teams
Commitment to research and prototype ideas
No previous product-development experience required
TEXT,
                'outcomes' => <<<'TEXT'
Identify and define meaningful problems
Research users and project requirements
Develop and compare solution concepts
Create and test prototypes
Improve products using feedback
Present a validated product concept
TEXT,
                'curriculum' => [
                    [
                        'title' => 'Problem Discovery',
                        'description' => 'Identifying opportunities, conducting research, and defining user needs.',
                    ],
                    [
                        'title' => 'Idea Development',
                        'description' => 'Brainstorming, concept comparison, technical feasibility, and solution selection.',
                    ],
                    [
                        'title' => 'Design and Prototyping',
                        'description' => 'Creating models, technical designs, mock-ups, and functional prototypes.',
                    ],
                    [
                        'title' => 'Testing and Validation',
                        'description' => 'Collecting feedback, analysing results, and improving product performance.',
                    ],
                    [
                        'title' => 'Product Presentation',
                        'description' => 'Preparing documentation, demonstrations, value propositions, and development plans.',
                    ],
                ],
                'sort_order' => 50,
                'is_featured' => false,
            ],
            [
                'category_slug' => 'industrial-engineering',
                'title' => 'Industrial Automation and Control',
                'short_description' => 'Learn sensors, control systems, automation concepts, process monitoring, and industrial implementation.',
                'description' => <<<'TEXT'
This practical programme introduces industrial automation, control systems, sensors, actuators, electrical control, process monitoring, and automation project development.

Learners complete guided exercises and build a small industrial-control demonstration.
TEXT,
                'duration' => '10 Weeks',
                'delivery_mode' => 'Hands-on Technical Training',
                'schedule' => 'Weekend and weekday sessions',
                'location' => 'VTLABS Engineering Laboratory',
                'requirements' => <<<'TEXT'
Interest in industrial systems
Basic understanding of electricity is helpful
Commitment to follow laboratory safety procedures
Ability to complete practical exercises
TEXT,
                'outcomes' => <<<'TEXT'
Understand industrial automation principles
Work with sensors and actuators
Interpret basic electrical control diagrams
Build simple control sequences
Monitor industrial processes
Complete an automation demonstration project
TEXT,
                'curriculum' => [
                    [
                        'title' => 'Industrial Control Fundamentals',
                        'description' => 'Automation concepts, industrial safety, control architecture, and common applications.',
                    ],
                    [
                        'title' => 'Sensors and Actuators',
                        'description' => 'Industrial sensing, switching, motors, relays, valves, and output devices.',
                    ],
                    [
                        'title' => 'Control Logic',
                        'description' => 'Control sequences, interlocks, timers, counters, and operational logic.',
                    ],
                    [
                        'title' => 'Process Monitoring',
                        'description' => 'Status indication, measurements, alarms, data collection, and operator interfaces.',
                    ],
                    [
                        'title' => 'Automation Project',
                        'description' => 'Designing, wiring, programming, testing, and presenting a small automated system.',
                    ],
                ],
                'sort_order' => 60,
                'is_featured' => false,
            ],
        ];

        foreach ($courses as $courseData) {
            $categorySlug = $courseData['category_slug'];
            unset($courseData['category_slug']);

            $slug = Str::slug($courseData['title']);

            Course::updateOrCreate(
                ['slug' => $slug],
                [
                    'course_category_id' => $categoryModels[$categorySlug]->id,
                    'title' => $courseData['title'],
                    'short_description' => $courseData['short_description'],
                    'description' => $courseData['description'],
                    'duration' => $courseData['duration'],
                    'delivery_mode' => $courseData['delivery_mode'],
                    'schedule' => $courseData['schedule'],
                    'location' => $courseData['location'],
                    'fee' => null,
                    'currency' => 'RWF',
                    'start_date' => null,
                    'application_deadline' => null,
                    'max_students' => null,
                    'requirements' => $courseData['requirements'],
                    'outcomes' => $courseData['outcomes'],
                    'curriculum' => $courseData['curriculum'],
                    'is_featured' => $courseData['is_featured'],
                    'is_published' => true,
                    'sort_order' => $courseData['sort_order'],
                    'views' => 0,
                    'meta_title' => $courseData['title'] . ' | VTLABS Academy',
                    'meta_description' => $courseData['short_description'],
                ]
            );
        }
    }
}
