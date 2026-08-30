<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function create(Menu $menu): View
    {
        $parents = $this->parentOptions($menu);

        $routeNames = $this->routeNames();

        return view(
            'admin.menu-items.create',
            compact(
                'menu',
                'parents',
                'routeNames'
            )
        );
    }

    public function store(
        Request $request,
        Menu $menu
    ): RedirectResponse {
        $validated = $this->validateItem(
            $request,
            $menu
        );

        $validated['menu_id'] = $menu->id;

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $validated = $this->cleanLinkFields($validated);

        MenuItem::create($validated);

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(
        Menu $menu,
        MenuItem $menuItem
    ): View {
        $this->ensureItemBelongsToMenu(
            $menu,
            $menuItem
        );

        $parents = $this->parentOptions(
            $menu,
            $menuItem
        );

        $routeNames = $this->routeNames();

        return view(
            'admin.menu-items.edit',
            compact(
                'menu',
                'menuItem',
                'parents',
                'routeNames'
            )
        );
    }

    public function update(
        Request $request,
        Menu $menu,
        MenuItem $menuItem
    ): RedirectResponse {
        $this->ensureItemBelongsToMenu(
            $menu,
            $menuItem
        );

        $validated = $this->validateItem(
            $request,
            $menu,
            $menuItem
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $validated = $this->cleanLinkFields($validated);

        $menuItem->update($validated);

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(
        Menu $menu,
        MenuItem $menuItem
    ): RedirectResponse {
        $this->ensureItemBelongsToMenu(
            $menu,
            $menuItem
        );

        if ($menuItem->children()->exists()) {
            return back()->with(
                'error',
                'Remove or reassign child links before deleting this menu item.'
            );
        }

        $menuItem->delete();

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu item deleted successfully.');
    }

    private function validateItem(
        Request $request,
        Menu $menu,
        ?MenuItem $menuItem = null
    ): array {
        return $request->validate([
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('menu_items', 'id')
                    ->where(
                        fn ($query) => $query->where(
                            'menu_id',
                            $menu->id
                        )
                    ),
                function (
                    string $attribute,
                    mixed $value,
                    \Closure $fail
                ) use ($menuItem) {
                    if (
                        $menuItem
                        && (int) $value === $menuItem->id
                    ) {
                        $fail(
                            'A menu item cannot be its own parent.'
                        );
                    }
                },
            ],
            'label' => [
                'required',
                'string',
                'max:150',
            ],
            'url' => [
                'nullable',
                'string',
                'max:500',
            ],
            'route_name' => [
                'nullable',
                'string',
                'max:200',
            ],
            'target' => [
                'required',
                Rule::in([
                    '_self',
                    '_blank',
                ]),
            ],
            'icon' => [
                'nullable',
                'string',
                'max:200',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:100000',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);
    }

    private function cleanLinkFields(array $validated): array
    {
        $validated['url'] = trim(
            (string) ($validated['url'] ?? '')
        ) ?: null;

        $validated['route_name'] = trim(
            (string) ($validated['route_name'] ?? '')
        ) ?: null;

        if ($validated['route_name']) {
            $validated['url'] = null;
        }

        return $validated;
    }

    private function parentOptions(
        Menu $menu,
        ?MenuItem $exclude = null
    ) {
        return $menu->allItems()
            ->whereNull('parent_id')
            ->when(
                $exclude,
                fn ($query) => $query->whereKeyNot(
                    $exclude->id
                )
            )
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();
    }

    private function routeNames(): array
    {
        return collect(Route::getRoutes())
            ->map(fn ($route) => $route->getName())
            ->filter()
            ->reject(
                fn ($name) => str_starts_with(
                    $name,
                    'admin.'
                )
            )
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function ensureItemBelongsToMenu(
        Menu $menu,
        MenuItem $menuItem
    ): void {
        abort_unless(
            $menuItem->menu_id === $menu->id,
            404
        );
    }
}
