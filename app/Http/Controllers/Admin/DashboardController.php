<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\HeroSlide;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use App\Models\QuotationRequest;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\TrainingApplication;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statistics = [
            'services' => Service::query()->count(),
            'products' => Product::query()->count(),
            'projects' => Project::query()->count(),
            'courses' => Course::query()->count(),

            'orders' => Order::query()->count(),
            'pending_orders' => Order::query()
                ->where('status', 'pending')
                ->count(),
            'completed_orders' => Order::query()
                ->where('status', 'completed')
                ->count(),
            'completed_sales' => Order::query()
                ->where('status', 'completed')
                ->sum('total'),

            'applications' => TrainingApplication::query()->count(),
            'messages' => ContactMessage::query()->count(),
            'quotations' => QuotationRequest::query()->count(),

            'pages' => Page::query()->count(),
            'hero_slides' => HeroSlide::query()->count(),
            'announcements' => Announcement::query()->count(),
            'team_members' => TeamMember::query()->count(),
        ];

        $recentApplications = TrainingApplication::query()
            ->latest()
            ->limit(5)
            ->get();

        $recentMessages = ContactMessage::query()
            ->latest()
            ->limit(5)
            ->get();

        $recentQuotations = QuotationRequest::query()
            ->latest()
            ->limit(5)
            ->get();

        $recentOrders = Order::query()
            ->withCount('items')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'statistics',
            'recentApplications',
            'recentMessages',
            'recentQuotations',
            'recentOrders'
        ));
    }
}
