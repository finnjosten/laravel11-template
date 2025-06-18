<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller {

    /** Data functions **/

    public function index() {
        $menus = Menu::all();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $menus
            ]);
        }
        return view('pages.account.menus.index', compact('menus'));
    }

    public function show($id) {
        $menu = Menu::find($id);
        if (!$menu) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu not found'
                ], 404);
            }
            return redirect()->route('dashboard.menus')->with('error', 'Menu not found');
        }

        $pages = Page::select('id', 'title', 'slug')->get();
        $menuItems = $menu->getStructuredItems();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'menu' => $menu,
                    'items' => $menuItems
                ]
            ]);
        }
        return view('pages.account.menus.show', [
            'menu' => $menu,
            'pages' => $pages,
            'menuItems' => $menuItems
        ]);
    }



    public function create() {
        return view('pages.account.menus.manage', ['mode' => 'add']);
    }

    public function store(Request $request) {
        $data = $request->only('name', 'location', 'description');

        $this->validate($data, [
            'name' => 'required',
            'location' => 'required|unique:menus',
            'description' => 'nullable'
        ]);

        $menu = Menu::create($data);

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Menu has been created',
                'data' => $menu
            ]);
        }
        return redirect()->route('dashboard.menus')->with('success', 'Menu created successfully');
    }



    public function edit($id) {
        $menu = Menu::findOrFail($id);

        $pages = Page::select('id', 'title', 'slug')->get();
        $menuItems = $menu->getStructuredItems();

        return view('pages.account.menus.manage', [
            'mode' => 'edit',
            'menu' => $menu,
            'pages' => $pages,
            'menuItems' => $menuItems
        ]);
    }

    public function update(Request $request, $id) {
        $menu = Menu::find($id);
        if (!$menu) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu not found'
                ], 404);
            }
            return redirect()->route('dashboard.menus')->with('error', 'Menu not found');
        }

        $data = $request->only('name', 'location', 'description', 'items');

        $this->validate($data, [
            'name' => 'required',
            'location' => 'required|unique:menus,location,' . $menu->id,
            'description' => 'nullable',
            'items' => 'nullable|json',
        ]);

        $menu->update([
            'name' => $data['name'],
            'location' => $data['location'],
            'description' => $data['description']
        ]);

        // Handle menu items update
        if (isset($data['items'])) {
            $items = json_decode($data['items'], true);

            // First, remove all existing items
            $menu->allItems()->delete();

            // Then create new items from the structured data
            foreach ($items as $itemData) {
                $this->createMenuItem($itemData, $menu->id);
            }
        }

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Menu updated successfully',
                'data' => $menu
            ]);
        }
        return redirect()->route('dashboard.menus')->with('success', 'Menu updated successfully');
    }



    public function trash($id) {
        $menu = Menu::findOrFail($id);

        return view('pages.account.menus.manage', ['mode' => 'delete', 'menu' => $menu]);
    }

    public function destroy($id) {
        $menu = Menu::find($id);
        if (!$menu) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu not found'
                ], 404);
            }
            return redirect()->route('dashboard.menus')->with('error', 'Menu not found');
        }

        $menu->delete();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Menu deleted successfully'
            ]);
        }
        return redirect()->route('dashboard.menus')->with('success', 'Menu deleted successfully');
    }



    /** Helper functions **/

    /**
     * Create menu item from structured data.
     *
     * @param array $itemData
     * @param int $menuId
     * @param int|null $parentId
     */
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
