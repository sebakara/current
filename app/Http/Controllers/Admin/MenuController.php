<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::query()
            ->withCount('allItems')
            ->orderBy('name')
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create(): View
    {
        return view('admin.menus.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMenu($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $menu = Menu::create($validated);

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu created successfully.');
    }

    public function show(Menu $menu): View
    {
        $menu->load([
            'allItems.parent',
            'allItems.children',
        ]);

        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu): View
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(
        Request $request,
        Menu $menu
    ): RedirectResponse {
        $validated = $this->validateMenu(
            $request,
            $menu
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $menu->update($validated);

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        if ($menu->allItems()->exists()) {
            return back()->with(
                'error',
                'Remove all menu items before deleting this menu.'
            );
        }

        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }

    private function validateMenu(
        Request $request,
        ?Menu $menu = null
    ): array {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'location' => [
                'required',
                'string',
                'max:100',
                Rule::unique('menus', 'location')
                    ->ignore($menu?->id),
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);
    }
}
