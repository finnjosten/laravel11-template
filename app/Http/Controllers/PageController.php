<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller {

    /** Data functions **/

    public function index() {
        $pages = Page::all();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $pages
            ]);
        }
        return view('pages.account.pages.index', ['pages' =>$pages]);
    }

    public function show($identifier = null) {
        // Handle identifier differently based on response type
        $page = null;

        if (API_RESPONSE) {
            $id = intval($identifier) ?? 0;
            $page = Page::find($id);
        } else {
            $slug = $identifier;

            // Handle home page cases
            if ($slug == "{none}") {
                abort(404); // {none} is just a placeholder, not a real page
            } elseif (empty($slug)) {
                $page = Page::where('slug', "{none}")->first(); // Empty slug means home page
            } else {
                $page = Page::where('slug', $slug)->first();
            }

        }

        // Handle page not found
        if (!$page) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Page not found',
                ], 404);
            }
            abort(404);
        }

        $isPrivate = $page->status === "private";
        $isDraft = $page->status === "draft";

        // Check permissions for private/draft pages
        if (($isPrivate && !auth()->check()) || $isDraft) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Page not found',
                ], 404);
            }
            abort(404);
        }

        // Return appropriate response
        if (API_RESPONSE) {
            return response()->json([
                'status' => $isPrivate ? 'warning' : 'success',
                'message' => $isPrivate ? 'This is a private page' : null,
                'data' => $page
            ]);
        } else {
            if ($isPrivate) {
                session()->flash('warning', "This is a private page");
            }
            return view('pages.dynamic', ['page' => $page]);
        }
    }



    public function create() {
        return view('pages.account.pages.manage', ['mode' => 'add']);
    }

    public function store(Request $request) {
        $data = $request->only('title', 'slug', 'content', 'status', 'parent_id');

        $this->validate($data, [
            'title' => 'required',
            'slug' => 'nullable',
            'content' => 'required|json',
            'status' => 'required|in:draft,published,private',
            'parent_id' => 'nullable|exists:pages,id',
        ]);

        $slug = $data['slug'];
        $parent_id = $validated['parent_id'] ?? null;

        if ($slug == "") {
            $slug = Str::slug($data['title']);
        }

        if (str_contains($slug, '/')) {
            $slug = Str::afterLast($slug, '/');
        }
        if ($parent_id) {
            $parent = Page::findOrFail($parent_id);
            $slug = $parent->slug . '/' . $slug;
        }

        $data['slug'] = $slug;

        // Check if the slug already exists
        $existingPage = Page::where('slug', "=", $slug)->first();
        if ($existingPage) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Slug is already taken',
                ], 422);
            }
            return redirect()->back()->with('error', 'Slug is already taken.')->withInput();
        }

        // Check if there is already a route with this slug
        $router = app('router');
        $routes = $router->getRoutes();
        $routeExists = $routes->match(request()->create('/' . $slug));

        if ($routeExists && !$routeExists->isFallback) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Slug can\'t be used',
                ], 422);
            }
            return redirect()->back()->with('error', 'Slug can\'t be used.')->withInput();
        }

        $page = Page::create($data);

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Page has been created',
                'data' => $page
            ]);
        }
        return redirect()->route('dashboard.pages')->with('success', 'Page has been created');
    }



    public function edit($id) {
        $page = Page::findOrFail($id);

        return view('pages.account.pages.manage', [
            'mode' => 'edit',
            'page' => $page
        ]);
    }

    public function update(Request $request, $id) {
        $page = Page::find($id);
        if (!$page) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Page not found',
                ], 404);
            }
            return redirect()->back()->with('error', 'Page not found')->withInput();
        }

        $data = $request->only('title', 'slug', 'content', 'status', 'parent_id');

        $this->validate($data, [
            'title' => 'required',
            'slug' => 'nullable',
            'content' => 'required|json',
            'status' => 'required|in:draft,published,private',
            'parent_id' => 'nullable|exists:pages,id',
        ]);

        $slug = $data['slug'];
        $parent_id = $data['parent_id'] ?? null;

        if ($slug == "") {
            $slug = Str::slug($data['title']);
        }

        if (str_contains($slug, '/')) {
            $slug = Str::afterLast($slug, '/');
        }
        if ($parent_id) {
            $parent = Page::findOrFail($parent_id);
            $slug = $parent->slug . '/' . $slug;
        }

        $data['slug'] = $slug;

        // Check if the slug already exists
        $existingPage = Page::where('slug', $slug)
            ->where('id', '!=', $page->id) // Exclude the current page
            ->first();
        if ($existingPage) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Slug is already taken',
                ], 422);
            }
            return redirect()->back()->with('error', 'Slug is already taken.')->withInput();
        }

        // Check if there is already a route with this slug
        $router = app('router');
        $routes = $router->getRoutes();
        $routeExists = $routes->match(request()->create('/' . $slug));

        if ($routeExists && !$routeExists->isFallback) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Slug can\'t be used',
                ], 422);
            }
            return redirect()->back()->with('error', 'Slug can\'t be used.')->withInput();
        }

        $page->update($data);

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Page has been updated',
                'data' => $page
            ]);
        }
        return redirect()->route('dashboard.pages')->with('success', 'Page has been updated');
    }



    public function trash($id) {
        $page = Page::findOrFail($id);
        return view('pages.account.pages.manage', [
            'mode' => 'delete',
            'page' => $page
        ]);
    }

    public function destroy($id) {
        $page = Page::find($id);

        if (!$page) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Page could not be found',
                ], 404);
            }
            return redirect()->back()->with('error', 'Page could not be found')->withInput();
        }

        $page->delete();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Page has been deleted',
            ]);
        }
        return redirect()->route('dashboard.pages')->with('success', 'Page has been deleted');
    }
}
