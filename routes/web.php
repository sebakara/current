<?php
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\VtlWoodsController;
use App\Http\Controllers\Frontend\AcademyController;
use App\Http\Controllers\Frontend\TrainingApplicationController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ManufacturingController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/services', [FrontendServiceController::class, 'index'])
    ->name('services.index');

Route::get(
    '/services/{service:slug}',
    [FrontendServiceController::class, 'show']
)->name('services.show');



Route::get('/about', [AboutController::class, 'index'])
    ->name('about');

Route::get(
    '/manufacturing',
    [ManufacturingController::class, 'index']
)->name('manufacturing');

Route::get('/products', [ProductController::class, 'index'])
    ->name('products');

Route::get('/products/{product:slug}', [ProductController::class, 'show'])
    ->name('products.show');


Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/products/{product:slug}', [
    CartController::class,
    'add',
])->name('cart.add');

Route::patch('/cart/{key}', [
    CartController::class,
    'update',
])->name('cart.update');

Route::delete('/cart/{key}', [
    CartController::class,
    'remove',
])->name('cart.remove');


Route::delete('/cart', [
    CartController::class,
    'clear',
])->name('cart.clear');

Route::get('/checkout', [
    CheckoutController::class,
    'index',
])->name('checkout.index');

Route::post('/checkout/whatsapp', [
    CheckoutController::class,
    'whatsapp',
])->name('checkout.whatsapp');

Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects');

Route::get('/projects/{project:slug}', [
    ProjectController::class,
    'show',
])->name('projects.show');



Route::get('/academy', [AcademyController::class, 'index'])
    ->name('academy');

Route::get('/academy/courses/{course:slug}', [
    AcademyController::class,
    'show',
])->name('academy.courses.show');

Route::get('/academy/courses/{course:slug}/apply', [
    TrainingApplicationController::class,
    'create',
])->name('academy.courses.apply');

Route::post('/academy/courses/{course:slug}/apply', [
    TrainingApplicationController::class,
    'store',
])->name('academy.courses.apply.store');

Route::get('/academy/application/{application}/success', [
    TrainingApplicationController::class,
    'success',
])->name('academy.application.success');

Route::get('/vtl-woods', [VtlWoodsController::class, 'index'])
    ->name('vtl-woods');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');

Route::post('/contact/message', [
    ContactController::class,
    'storeMessage',
])->name('contact.message.store');

Route::post('/contact/quotation', [
    ContactController::class,
    'storeQuotation',
])->name('contact.quotation.store');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::patch(
                '/service-categories/{service_category}/toggle-status',
                [ServiceCategoryController::class, 'toggleStatus']
            )->name('service-categories.toggle-status');

            Route::resource(
                'service-categories',
                ServiceCategoryController::class
            );
Route::resource(
    'announcements',
    \App\Http\Controllers\Admin\AnnouncementController::class
)->names('announcements');


Route::get(
    'settings',
    [
        \App\Http\Controllers\Admin\SettingController::class,
        'index',
    ]
)->name('settings.index');

Route::put(
    'settings',
    [
        \App\Http\Controllers\Admin\SettingController::class,
        'update',
    ]
)->name('settings.update');
Route::resource(
    'social-links',
    \App\Http\Controllers\Admin\SocialLinkController::class
)->names('social-links');

Route::get(
    'footer-sections/{footerSection}/links/create',
    [
        \App\Http\Controllers\Admin\FooterLinkController::class,
        'create',
    ]
)->name('footer-sections.links.create');

Route::post(
    'footer-sections/{footerSection}/links',
    [
        \App\Http\Controllers\Admin\FooterLinkController::class,
        'store',
    ]
)->name('footer-sections.links.store');

Route::get(
    'footer-sections/{footerSection}/links/{footerLink}/edit',
    [
        \App\Http\Controllers\Admin\FooterLinkController::class,
        'edit',
    ]
)->name('footer-sections.links.edit');

Route::put(
    'footer-sections/{footerSection}/links/{footerLink}',
    [
        \App\Http\Controllers\Admin\FooterLinkController::class,
        'update',
    ]
)->name('footer-sections.links.update');

Route::delete(
    'footer-sections/{footerSection}/links/{footerLink}',
    [
        \App\Http\Controllers\Admin\FooterLinkController::class,
        'destroy',
    ]
)->name('footer-sections.links.destroy');

Route::resource(
    'footer-sections',
    \App\Http\Controllers\Admin\FooterSectionController::class
)->names('footer-sections');


Route::get(
    'menus/{menu}/items/create',
    [
        \App\Http\Controllers\Admin\MenuItemController::class,
        'create',
    ]
)->name('menus.items.create');

Route::post(
    'menus/{menu}/items',
    [
        \App\Http\Controllers\Admin\MenuItemController::class,
        'store',
    ]
)->name('menus.items.store');

Route::get(
    'menus/{menu}/items/{menuItem}/edit',
    [
        \App\Http\Controllers\Admin\MenuItemController::class,
        'edit',
    ]
)->name('menus.items.edit');

Route::put(
    'menus/{menu}/items/{menuItem}',
    [
        \App\Http\Controllers\Admin\MenuItemController::class,
        'update',
    ]
)->name('menus.items.update');

Route::delete(
    'menus/{menu}/items/{menuItem}',
    [
        \App\Http\Controllers\Admin\MenuItemController::class,
        'destroy',
    ]
)->name('menus.items.destroy');

Route::resource(
    'menus',
    \App\Http\Controllers\Admin\MenuController::class
)->names('menus');



Route::resource(
    'team-members',
    \App\Http\Controllers\Admin\TeamMemberController::class
)->names('team-members');

Route::resource(
    'hero-slides',
    \App\Http\Controllers\Admin\HeroSlideController::class
)->names('hero-slides');


Route::resource(
    'projects',
    \App\Http\Controllers\Admin\ProjectController::class
)->names('projects');



Route::get(
    'pages/{page}/sections',
    [
        \App\Http\Controllers\Admin\PageSectionController::class,
        'index',
    ]
)->name('pages.sections.index');

Route::get(
    'pages/{page}/sections/create',
    [
        \App\Http\Controllers\Admin\PageSectionController::class,
        'create',
    ]
)->name('pages.sections.create');

Route::post(
    'pages/{page}/sections',
    [
        \App\Http\Controllers\Admin\PageSectionController::class,
        'store',
    ]
)->name('pages.sections.store');

Route::get(
    'pages/{page}/sections/{section}/edit',
    [
        \App\Http\Controllers\Admin\PageSectionController::class,
        'edit',
    ]
)->name('pages.sections.edit');

Route::put(
    'pages/{page}/sections/{section}',
    [
        \App\Http\Controllers\Admin\PageSectionController::class,
        'update',
    ]
)->name('pages.sections.update');

Route::delete(
    'pages/{page}/sections/{section}',
    [
        \App\Http\Controllers\Admin\PageSectionController::class,
        'destroy',
    ]
)->name('pages.sections.destroy');







Route::resource(
    'pages',
    \App\Http\Controllers\Admin\PageController::class
)->names('pages');

Route::get(
    'quotation-requests',
    [
        \App\Http\Controllers\Admin\QuotationRequestController::class,
        'index',
    ]
)->name('quotation-requests.index');


Route::resource(
    'courses',
    \App\Http\Controllers\Admin\CourseController::class
)->names('courses');

Route::resource(
    'products',
    \App\Http\Controllers\Admin\ProductController::class
)->names('products');


Route::get(
    'quotation-requests/{quotationRequest}',
    [
        \App\Http\Controllers\Admin\QuotationRequestController::class,
        'show',
    ]
)->name('quotation-requests.show');

Route::put(
    'quotation-requests/{quotationRequest}',
    [
        \App\Http\Controllers\Admin\QuotationRequestController::class,
        'update',
    ]
)->name('quotation-requests.update');

Route::delete(
    'quotation-requests/{quotationRequest}',
    [
        \App\Http\Controllers\Admin\QuotationRequestController::class,
        'destroy',
    ]
)->name('quotation-requests.destroy');

Route::resource(
    'course-categories',
    \App\Http\Controllers\Admin\CourseCategoryController::class
)->names('course-categories');

Route::resource(
    'project-categories',
    \App\Http\Controllers\Admin\ProjectCategoryController::class
)->names('project-categories');
Route::resource(
    'product-categories',
    \App\Http\Controllers\Admin\ProductCategoryController::class
)->names('product-categories');

Route::get(
    'contact-messages',
    [
        \App\Http\Controllers\Admin\ContactMessageController::class,
        'index',
    ]
)->name('contact-messages.index');

Route::get(
    'contact-messages/{contactMessage}',
    [
        \App\Http\Controllers\Admin\ContactMessageController::class,
        'show',
    ]
)->name('contact-messages.show');

Route::put(
    'contact-messages/{contactMessage}',
    [
        \App\Http\Controllers\Admin\ContactMessageController::class,
        'update',
    ]
)->name('contact-messages.update');

Route::delete(
    'contact-messages/{contactMessage}',
    [
        \App\Http\Controllers\Admin\ContactMessageController::class,
        'destroy',
    ]
)->name('contact-messages.destroy');

Route::get(
    'training-applications',
    [
        \App\Http\Controllers\Admin\TrainingApplicationController::class,
        'index',
    ]
)->name('training-applications.index');

Route::get(
    'training-applications/{trainingApplication}',
    [
        \App\Http\Controllers\Admin\TrainingApplicationController::class,
        'show',
    ]
)->name('training-applications.show');

Route::put(
    'training-applications/{trainingApplication}',
    [
        \App\Http\Controllers\Admin\TrainingApplicationController::class,
        'update',
    ]
)->name('training-applications.update');

Route::delete(
    'training-applications/{trainingApplication}',
    [
        \App\Http\Controllers\Admin\TrainingApplicationController::class,
        'destroy',
    ]
)->name('training-applications.destroy');



            Route::patch(
                '/services/{service}/toggle-publish',
                [AdminServiceController::class, 'togglePublish']
            )->name('services.toggle-publish');

            Route::patch(
                '/services/{service}/toggle-featured',
                [AdminServiceController::class, 'toggleFeatured']
            )->name('services.toggle-featured');

            Route::resource(
                'services',
                AdminServiceController::class
            );
Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders.index');

Route::get('/orders/{order}', [OrderController::class, 'show'])
    ->name('orders.show');

Route::patch('/orders/{order}/status', [
    OrderController::class,
    'updateStatus',
])->name('orders.update-status');
        });

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
