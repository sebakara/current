<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\FooterSection;
use App\Models\Menu;
use App\Models\SocialLink;
use App\Services\CartService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('frontend.*', function ($view): void {
            $headerMenu = Cache::remember(
                'website.header-menu',
                now()->addHour(),
                fn () => Menu::query()
                    ->where('location', 'header')
                    ->where('is_active', true)
                    ->with([
                        'items' => fn ($query) => $query
                            ->where('is_active', true)
                            ->with([
                                'children' => fn ($childQuery) => $childQuery
                                    ->where('is_active', true)
                                    ->orderBy('sort_order'),
                            ])
                            ->orderBy('sort_order'),
                    ])
                    ->first()
            );

            $footerSections = Cache::remember(
                'website.footer-sections',
                now()->addHour(),
                fn () => FooterSection::query()
                    ->where('is_active', true)
                    ->with([
                        'links' => fn ($query) => $query
                            ->where('is_active', true)
                            ->orderBy('sort_order'),
                    ])
                    ->orderBy('sort_order')
                    ->get()
            );

            $socialLinks = Cache::remember(
                'website.social-links',
                now()->addHour(),
                fn () => SocialLink::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get()
            );

            $announcement = Cache::remember(
                'website.active-announcement',
                now()->addMinutes(15),
                fn () => Announcement::query()
                    ->currentlyActive()
                    ->latest()
                    ->first()
            );

            /*
            |--------------------------------------------------------------------------
            | Shopping cart data
            |--------------------------------------------------------------------------
            |
            | Cart data is session-specific, so it must not be cached globally.
            |
            */

            $cartService = app(CartService::class);

            $cartItemCount = $cartService->count();

            $view->with([
                'headerMenu' => $headerMenu,
                'footerSections' => $footerSections,
                'socialLinks' => $socialLinks,
                'announcement' => $announcement,
                'cartItemCount' => $cartItemCount,
            ]);
        });
    }
}
