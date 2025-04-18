<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'location', 'description'];

    public function items() {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->with(['page:id,title,slug']);
    }

    public function allItems()
    {
        return $this->hasMany(MenuItem::class)->with(['page:id,title,slug']);
    }

    /**
     * Get all menu items in a hierarchical structure with minimal page data
     */
    public function getStructuredItems()
    {
        $items = $this->allItems()
            ->select(['id', 'menu_id', 'parent_id', 'page_id', 'title', 'url', 'order', 'visibility', 'admin_only'])
            ->get();

        $rootItems = $items->whereNull('parent_id')->sortBy('order');

        foreach ($rootItems as $item) {
            $this->buildItemHierarchy($item, $items);
        }

        return $rootItems->values();
    }

    /**
     * Recursively build the menu item hierarchy
     */
    private function buildItemHierarchy($item, $allItems)
    {
        $children = $allItems->where('parent_id', $item->id)->sortBy('order');
        $item->children = $children->values();

        foreach ($children as $child) {
            $this->buildItemHierarchy($child, $allItems);
        }
    }
}
