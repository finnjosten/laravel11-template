<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'page_id',
        'title',
        'url',
        'order',
        'visibility',
        'admin_only'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class)->select(['id', 'title', 'slug']);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function shouldDisplay()
    {
        /** @var User|null */
        $user = Auth::user();
        if ($this->admin_only && (!$user || !$user->isAdmin())) {
            return false;
        }

        switch ($this->visibility) {
            case 'guest':
                return !Auth::check();
            case 'auth':
                return Auth::check();
            default:
                return true;
        }
    }

    public function url() {

        if (!$this->url) {
            return $this->page->slug;
        }

        if (!str_starts_with($this->url, 'http')) {
            if (str_starts_with($this->url, '/')) {
                $url = substr($this->url, 1);
            }
            $host = config('app.url');
            $url = $host . '/' . $url;
        }

        return $url;
    }
}
