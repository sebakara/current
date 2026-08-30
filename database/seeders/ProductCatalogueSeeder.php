<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices, control systems, circuit solutions, and custom hardware products.',
                'sort_order' => 10,
            ],
            [
                'name' => 'Smart Systems',
                'description' => 'Connected monitoring, automation, IoT, sensing, and intelligent control products.',
                'sort_order' => 20,
            ],
            [
                'name' => 'Education',
                'description' => 'Technical training kits, laboratory equipment, and practical learning products.',
                'sort_order' => 30,
            ],
            [
                'name' => 'Manufacturing',
                'description' => 'Fabricated components, prototypes, production aids, and custom manufactured products.',
                'sort_order' => 40,
            ],
            [
                'name' => 'Software Solutions',
                'description' => 'Digital platforms, business systems, monitoring applications, and custom software products.',
                'sort_order' => 50,
            ],
            [
                'name' => 'VTL Woods',
                'description' => 'Custom furniture, wood products, fitted interiors, and made-to-measure solutions.',
                'sort_order' => 60,
            ],
        ];

        $categoryModels = [];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);

            $categoryModels[$slug] = ProductCategory::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => true,
                    'sort_order' => $category['sort_order'],
                ]
            );
        }

        $products = [
            [
                'category_slug' => 'electronics',
                'name' => 'Custom Electronic Controller',
                'sku' => 'VTL-EC-001',
                'short_description' => 'A customizable embedded control solution for automation, monitoring, and smart-system applications.',
                'description' => <<<'TEXT'
The Custom Electronic Controller is developed for projects that require reliable sensing, control, automation, and equipment integration.

It can be configured around different inputs, outputs, sensors, communication methods, power requirements, enclosures, and operating conditions.

This product is suitable for industrial systems, agricultural technology, laboratory equipment, smart buildings, training projects, and custom machinery.
TEXT,
                'features' => [
                    'Custom input and output configuration',
                    'Sensor and actuator integration',
                    'Programmable control logic',
                    'Optional Wi-Fi, Bluetooth, or GSM connectivity',
                    'Custom enclosure and mounting options',
                    'Technical documentation and implementation support',
                ],
                'specifications' => [
                    'Power supply' => 'Configured according to project requirements',
                    'Controller' => 'Microcontroller or embedded processor',
                    'Connectivity' => 'Optional Wi-Fi, Bluetooth, GSM, Ethernet, or serial',
                    'Inputs' => 'Digital, analogue, and sensor inputs',
                    'Outputs' => 'Relay, transistor, motor, display, or communication outputs',
                    'Enclosure' => 'Custom or standard enclosure',
                ],
                'price' => null,
                'currency' => 'RWF',
                'show_price' => false,
                'minimum_order_quantity' => 1,
                'stock_quantity' => null,
                'manage_stock' => false,
                'allow_backorders' => true,
                'cart_enabled' => true,
                'whatsapp_order_enabled' => true,
                'options' => [
                    [
                        'name' => 'Connectivity',
                        'values' => [
                            'Standard',
                            'Wi-Fi',
                            'Bluetooth',
                            'GSM',
                            'Ethernet',
                        ],
                    ],
                    [
                        'name' => 'Enclosure',
                        'values' => [
                            'Basic',
                            'Wall-mounted',
                            'Industrial',
                            'Custom',
                        ],
                    ],
                ],
                'is_featured' => true,
                'sort_order' => 10,
            ],
            [
                'category_slug' => 'smart-systems',
                'name' => 'IoT Monitoring Device',
                'sku' => 'VTL-IOT-001',
                'short_description' => 'Connected monitoring hardware for environments, equipment, agriculture, laboratories, and field operations.',
                'description' => <<<'TEXT'
The IoT Monitoring Device collects, processes, and transmits data from sensors installed in a selected environment.

It can be adapted for temperature, humidity, water level, electricity, machine status, soil conditions, movement, security, production, and other monitoring applications.

The solution can include a dashboard, alerts, reports, data history, and remote device management.
TEXT,
                'features' => [
                    'Real-time sensor monitoring',
                    'Remote dashboard access',
                    'Configurable alerts and notifications',
                    'Historical data and reporting',
                    'Multiple connectivity options',
                    'Custom sensor integration',
                ],
                'specifications' => [
                    'Sensors' => 'Configured according to application',
                    'Connectivity' => 'Wi-Fi, GSM, LoRa, Bluetooth, or Ethernet',
                    'Dashboard' => 'Web or mobile dashboard',
                    'Alerts' => 'SMS, email, dashboard, or WhatsApp integration',
                    'Power' => 'Mains, battery, or solar options',
                    'Installation' => 'Indoor or outdoor configuration',
                ],
                'price' => null,
                'currency' => 'RWF',
                'show_price' => false,
                'minimum_order_quantity' => 1,
                'stock_quantity' => null,
                'manage_stock' => false,
                'allow_backorders' => true,
                'cart_enabled' => true,
                'whatsapp_order_enabled' => true,
                'options' => [
                    [
                        'name' => 'Connectivity',
                        'values' => [
                            'Wi-Fi',
                            'GSM',
                            'LoRa',
                            'Ethernet',
                        ],
                    ],
                    [
                        'name' => 'Power Option',
                        'values' => [
                            'Mains',
                            'Battery',
                            'Solar',
                        ],
                    ],
                ],
                'is_featured' => true,
                'sort_order' => 20,
            ],
            [
                'category_slug' => 'education',
                'name' => 'Technical Training Kit',
                'sku' => 'VTL-EDU-001',
                'short_description' => 'A practical learning platform for electronics, programming, embedded systems, and prototyping.',
                'description' => <<<'TEXT'
The Technical Training Kit is designed for schools, universities, technical institutions, laboratories, training centres, and individual learners.

It combines electronic components, sensors, development boards, practical exercises, documentation, and guided projects.

The contents can be customized according to the subject, learner level, number of students, curriculum, and available laboratory equipment.
TEXT,
                'features' => [
                    'Reusable practical components',
                    'Guided exercises and project activities',
                    'Suitable for individual or group learning',
                    'Customizable according to curriculum',
                    'Electronics and programming integration',
                    'Optional trainer support',
                ],
                'specifications' => [
                    'Target users' => 'Schools, universities, training centres, and individuals',
                    'Learning areas' => 'Electronics, programming, IoT, and embedded systems',
                    'Documentation' => 'Practical manual and exercises',
                    'Packaging' => 'Portable training box or laboratory set',
                    'Customization' => 'Available by institution and curriculum',
                    'Support' => 'Optional instructor training',
                ],
                'price' => null,
                'currency' => 'RWF',
                'show_price' => false,
                'minimum_order_quantity' => 1,
                'stock_quantity' => null,
                'manage_stock' => false,
                'allow_backorders' => true,
                'cart_enabled' => true,
                'whatsapp_order_enabled' => true,
                'options' => [
                    [
                        'name' => 'Training Level',
                        'values' => [
                            'Beginner',
                            'Intermediate',
                            'Advanced',
                        ],
                    ],
                    [
                        'name' => 'Kit Size',
                        'values' => [
                            'Individual',
                            'Small Group',
                            'Laboratory Set',
                        ],
                    ],
                ],
                'is_featured' => true,
                'sort_order' => 30,
            ],
            [
                'category_slug' => 'manufacturing',
                'name' => 'Custom Prototype Assembly',
                'sku' => 'VTL-MFG-001',
                'short_description' => 'A custom physical prototype developed from your concept, drawing, model, or technical requirement.',
                'description' => <<<'TEXT'
The Custom Prototype Assembly service helps innovators, companies, students, researchers, and institutions convert ideas into functional physical products.

Depending on the project, the prototype may combine 3D-printed parts, electronics, machined components, woodwork, metalwork, sensors, enclosures, and software.
TEXT,
                'features' => [
                    'Concept and technical review',
                    'Mechanical and electronic integration',
                    'Rapid prototyping',
                    'Functional testing',
                    'Design improvement support',
                    'Small-batch production options',
                ],
                'specifications' => [
                    'Production method' => 'Selected according to the project',
                    'Materials' => 'Plastic, wood, metal, electronics, or mixed materials',
                    'Design input' => 'Sketch, drawing, CAD model, or written requirement',
                    'Quantity' => 'Single prototype or small batch',
                    'Testing' => 'Functional and physical testing',
                    'Documentation' => 'Available upon request',
                ],
                'price' => null,
                'currency' => 'RWF',
                'show_price' => false,
                'minimum_order_quantity' => 1,
                'stock_quantity' => null,
                'manage_stock' => false,
                'allow_backorders' => true,
                'cart_enabled' => true,
                'whatsapp_order_enabled' => true,
                'options' => [
                    [
                        'name' => 'Project Stage',
                        'values' => [
                            'Concept only',
                            'Existing design',
                            'Prototype improvement',
                            'Small production run',
                        ],
                    ],
                ],
                'is_featured' => false,
                'sort_order' => 40,
            ],
            [
                'category_slug' => 'software-solutions',
                'name' => 'Business Management System',
                'sku' => 'VTL-SW-001',
                'short_description' => 'A customizable digital platform for managing operations, records, users, reports, and workflows.',
                'description' => <<<'TEXT'
The Business Management System is developed around the actual processes of an organisation.

It can support customers, stock, employees, finance, production, services, reports, approvals, documents, notifications, and role-based access.

The system can be deployed as a web application and extended with mobile access, APIs, dashboards, integrations, and automated reports.
TEXT,
                'features' => [
                    'Role-based user access',
                    'Operational dashboards',
                    'Custom workflow management',
                    'Reports and data exports',
                    'Secure database management',
                    'Optional mobile and API integration',
                ],
                'specifications' => [
                    'Platform' => 'Web-based system',
                    'Users' => 'Configurable by organisation',
                    'Hosting' => 'Cloud or private server',
                    'Security' => 'Authentication and role permissions',
                    'Reports' => 'Dashboard, PDF, spreadsheet, and custom reports',
                    'Customization' => 'Built around business requirements',
                ],
                'price' => null,
                'currency' => 'RWF',
                'show_price' => false,
                'minimum_order_quantity' => 1,
                'stock_quantity' => null,
                'manage_stock' => false,
                'allow_backorders' => true,
                'cart_enabled' => true,
                'whatsapp_order_enabled' => true,
                'options' => [
                    [
                        'name' => 'Deployment',
                        'values' => [
                            'Cloud hosting',
                            'Private server',
                            'Local network',
                        ],
                    ],
                ],
                'is_featured' => false,
                'sort_order' => 50,
            ],
            [
                'category_slug' => 'vtl-woods',
                'name' => 'Custom Office Workstation',
                'sku' => 'VTL-WOOD-001',
                'short_description' => 'A made-to-measure office workstation designed around the space, equipment, storage, and working style.',
                'description' => <<<'TEXT'
The Custom Office Workstation is designed according to the available room, number of users, equipment, cable-management needs, storage requirements, and preferred finish.

It is suitable for offices, reception areas, schools, hotels, laboratories, home workspaces, and shared working environments.
TEXT,
                'features' => [
                    'Made-to-measure dimensions',
                    'Custom drawers and storage',
                    'Cable-management options',
                    'Choice of material and finish',
                    'Single-user or multi-user layouts',
                    'Delivery and installation available',
                ],
                'specifications' => [
                    'Dimensions' => 'Custom',
                    'Material' => 'Selected according to budget and design',
                    'Finish' => 'Multiple colour and finishing options',
                    'Storage' => 'Optional drawers, shelves, and cabinets',
                    'Installation' => 'Available',
                    'Quantity' => 'Single item or multiple workstations',
                ],
                'price' => null,
                'currency' => 'RWF',
                'show_price' => false,
                'minimum_order_quantity' => 1,
                'stock_quantity' => null,
                'manage_stock' => false,
                'allow_backorders' => true,
                'cart_enabled' => true,
                'whatsapp_order_enabled' => true,
                'options' => [
                    [
                        'name' => 'Workstation Type',
                        'values' => [
                            'Single user',
                            'Two users',
                            'Four users',
                            'Custom layout',
                        ],
                    ],
                    [
                        'name' => 'Finish',
                        'values' => [
                            'Natural wood',
                            'White',
                            'Black',
                            'Custom colour',
                        ],
                    ],
                ],
                'is_featured' => true,
                'sort_order' => 60,
            ],
        ];

        foreach ($products as $productData) {
            $categorySlug = $productData['category_slug'];
            unset($productData['category_slug']);

            $slug = Str::slug($productData['name']);

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'product_category_id' => $categoryModels[$categorySlug]->id,
                    'name' => $productData['name'],
                    'sku' => $productData['sku'],
                    'short_description' => $productData['short_description'],
                    'description' => $productData['description'],
                    'features' => $productData['features'],
                    'specifications' => $productData['specifications'],
                    'featured_image' => null,
                    'gallery' => [],
                    'video_url' => null,
                    'datasheet' => null,
                    'price' => $productData['price'],
                    'sale_price' => null,
                    'currency' => $productData['currency'],
                    'show_price' => $productData['show_price'],
                    'is_featured' => $productData['is_featured'],
                    'is_published' => true,
                    'sort_order' => $productData['sort_order'],
                    'views' => 0,
                    'minimum_order_quantity' => $productData['minimum_order_quantity'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'manage_stock' => $productData['manage_stock'],
                    'allow_backorders' => $productData['allow_backorders'],
                    'cart_enabled' => $productData['cart_enabled'],
                    'whatsapp_order_enabled' => $productData['whatsapp_order_enabled'],
                    'options' => $productData['options'],
                    'meta_title' => $productData['name'] . ' | VTLABS',
                    'meta_description' => $productData['short_description'],
                ]
            );
        }
    }
}
