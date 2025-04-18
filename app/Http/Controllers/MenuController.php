<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index() {
        $menus = Menu::all();
        return view('pages.account.menus.index', compact('menus'));
    }

    public function create() {
        return view('pages.account.menus.manage', ['mode' => 'add']);
    }

    public function edit(Menu $menu) {
        $pages = Page::select('id', 'title', 'slug')->get();
        $menuItems = $menu->getStructuredItems();
        return view('pages.account.menus.manage', [
            'mode' => 'edit',
            'menu' => $menu,
            'pages' => $pages,
            'menuItems' => $menuItems
        ]);
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'location' => 'required|unique:menus',
                'description' => 'nullable'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        Menu::create($validated);
        return redirect()->route('dashboard.menus')->with('success', 'Menu created successfully');
    }

    public function update(Request $request, Menu $menu) {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'location' => 'required|unique:menus,location,' . $menu->id,
                'description' => 'nullable',
                'items' => 'nullable|json'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        $menu->update([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'description' => $validated['description']
        ]);

        // Handle menu items update
        if (isset($validated['items'])) {
            $items = json_decode($validated['items'], true);

            // First, remove all existing items
            $menu->allItems()->delete();

            // Then create new items from the structured data
            foreach ($items as $itemData) {
                $this->createMenuItem($itemData, $menu->id);
            }
        }

        return redirect()->route('dashboard.menus')->with('success', 'Menu updated successfully');
    }

    public function trash(Menu $menu) {
        return view('pages.account.menus.manage', ['mode' => 'delete', 'menu' => $menu]);
    }

    public function destroy(Menu $menu) {
        $menu->delete();
        return redirect()->route('dashboard.menus')->with('success', 'Menu deleted successfully');
    }

    private function createMenuItem($itemData, $menuId, $parentId = null) {

        $item = MenuItem::create([
            'menu_id' => $menuId,
            'parent_id' => $parentId,
            'page_id' => $itemData['page_id'] ?? 0,
            'title' => $itemData['title'],
            'url' => $itemData['url'] ?? null,
            'order' => $itemData['order'] ?? 0,
            'visibility' => $itemData['visibility'] ?? 'all',
            'admin_only' => $itemData['admin_only'] ?? false
        ]);

        if (isset($itemData['children']) && is_array($itemData['children'])) {
            foreach ($itemData['children'] as $childData) {
                $this->createMenuItem($childData, $menuId, $item->id);
            }
        }
    }
}
