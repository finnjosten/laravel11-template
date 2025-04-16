<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index() {
        return view('pages.account.pages.index', ['pages' => Page::all()]);
    }

    public function show($slug) {
        $page = Page::where('slug', $slug)->first();
        $preview = false;

        if (!$page) abort(404);
        if ($page->status == "private") $preview = true;

        if ($page->status == "private" && !auth()->check()) {
            abort(404);
        } else if ($page->status == "draft") {
            abort(404);
        }

        if ($preview) {
            session()->flash('warning', "This is a private page");
            return view('pages.dynamic', ['page' => $page]);
        } else {
            return view('pages.dynamic', ['page' => $page]);
        }
    }

    public function create() {
        return view('pages.account.pages.manage', ['mode' => 'add']);
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'content' => 'required|json',
                'status' => 'required|in:draft,published,private',
                'parent_id' => 'nullable|exists:pages,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        // Clear any previous messages
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        $slug = $validated['slug'];
        $parent_id = $validated['parent_id'];

        if (str_contains($slug, '/')) {
            $slug = Str::afterLast($slug, '/');
        }
        if ($parent_id) {
            $parent = Page::findOrFail($parent_id);
            $slug = $parent->slug . '/' . $slug;
        }

        $validated['slug'] = $slug;

        // Check if the slug already exists
        $existingPage = Page::where('slug', $slug)->first();
        if ($existingPage) {
            return redirect()->back()->with('error', 'Slug is already taken.')->withInput();
        }

        $page = Page::create($validated);

        return redirect()->route('dashboard.pages')->with('success', 'Page has been created');
    }

    public function edit($page_id) {
        $page = Page::findOrFail($page_id);

        return view('pages.account.pages.manage', [
            'mode' => 'edit',
            'page' => $page
        ]);
    }

    public function update(Request $request, $page_id) {
        $page = Page::findOrFail($page_id);

        try {
            $validated = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'content' => 'required|json',
                'status' => 'required|in:draft,published,private',
                'parent_id' => 'nullable|exists:pages,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        // Clear any previous messages
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        $slug = $validated['slug'];
        $parent_id = $validated['parent_id'];

        if (str_contains($slug, '/')) {
            $slug = Str::afterLast($slug, '/');
        }
        if ($parent_id) {
            $parent = Page::findOrFail($parent_id);
            $slug = $parent->slug . '/' . $slug;
        }

        $validated['slug'] = $slug;

        // Check if the slug already exists
        $existingPage = Page::where('slug', $slug)
            ->where('id', '!=', $page->id) // Exclude the current page
            ->first();
        if ($existingPage) {
            return redirect()->back()->with('error', 'Slug is already taken.')->withInput();
        }


        $page->update($validated);

        return redirect()
            ->route('dashboard.pages')
            ->with('success', 'Page has been updated');
    }

    public function trash($page_id) {
        $page = Page::findOrFail($page_id);
        return view('pages.account.pages.manage', [
            'mode' => 'delete',
            'page' => $page
        ]);
    }

    public function destroy($page_id) {
        $page = Page::findOrFail($page_id);
        $page->delete();

        return redirect()
            ->route('dashboard.pages')
            ->with('success', 'Page has been deleted');
    }
}
