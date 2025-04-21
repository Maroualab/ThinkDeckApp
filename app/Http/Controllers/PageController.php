<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     */
  

    /**
     * Display a listing of the pages.
     */
    public function index()
    {
        $rootPages = Auth::user()->pages()->root()->active()->orderBy('position')->get();
        $favorites = Auth::user()->pages()->favorites()->active()->get();
        
        return view('pages.index', compact('rootPages', 'favorites'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(Request $request)
    {
        // Get workspace_id from request if provided
        $workspaceId = $request->workspace_id;
        $workspace = null;
        
        // If workspace_id is provided, validate it belongs to the user
        if ($workspaceId) {
            $workspace = Auth::user()->workspaces()->find($workspaceId);
        }
        
        return view('pages.create', compact('workspace'));
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'parent_id' => 'nullable|exists:pages,id',
            'is_template' => 'boolean',
            'workspace_id' => 'nullable|exists:workspaces,id',
        ]);

        // If no workspace_id is specified, use the active workspace from session
        if (!isset($validated['workspace_id']) && session('active_workspace_id')) {
            $validated['workspace_id'] = session('active_workspace_id');
        }

        // Get highest position value for siblings
        $position = 0;
        
        // Check if parent_id exists in the validated data before using it
        if (isset($validated['parent_id']) && $validated['parent_id']) {
            $position = Auth::user()->pages()
                ->where('parent_id', $validated['parent_id'])
                ->max('position') + 1;
        } else {
            $position = Auth::user()->pages()
                ->whereNull('parent_id')
                ->max('position') + 1;
        }

        $page = Auth::user()->pages()->create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'icon' => $validated['icon'] ?? '📄',
            'parent_id' => isset($validated['parent_id']) ? $validated['parent_id'] : null,
            'position' => $position,
            'is_template' => isset($validated['is_template']) ? $validated['is_template'] : false,
            'workspace_id' => $validated['workspace_id'] ?? null,
        ]);

         // Change the redirect to go back to the index page instead of the show page
        return redirect()->route('pages.index')->with('success', 'Page created successfully!');
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $breadcrumbs = $this->generateBreadcrumbs($page);
        $children = $page->children()->active()->get();
        
        return view('pages.show', compact('page', 'breadcrumbs', 'children'));
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'parent_id' => 'nullable|exists:pages,id',
            'is_favorite' => 'boolean',
            'is_template' => 'boolean',
        ]);

        // Prevent circular references
        if (isset($validated['parent_id']) && $validated['parent_id'] == $page->id) {
            return back()->withErrors(['parent_id' => 'A page cannot be its own parent.']);
        }

        $page->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? $page->content,
            'icon' => $validated['icon'] ?? $page->icon,
            'parent_id' => isset($validated['parent_id']) ? $validated['parent_id'] : $page->parent_id,
            'is_favorite' => isset($validated['is_favorite']) ? $validated['is_favorite'] : $page->is_favorite,
            'is_template' => isset($validated['is_template']) ? $validated['is_template'] : $page->is_template,
        ]);

        return redirect()->route('pages.show', $page)->with('success', 'Page updated successfully!');
    }

    /**
     * Update page positions (for drag-and-drop reordering).
     */
    public function updatePositions(Request $request)
    {
        $validated = $request->validate([
            'pages' => 'required|array',
            'pages.*.id' => 'required|exists:pages,id',
            'pages.*.position' => 'required|integer|min:0',
            'pages.*.parent_id' => 'nullable|exists:pages,id',
        ]);

        foreach ($validated['pages'] as $pageData) {
            $page = Page::find($pageData['id']);
            
            if ($page && $page->user_id === Auth::id()) {
                $page->update([
                    'position' => $pageData['position'],
                    'parent_id' => $pageData['parent_id'],
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Archive the specified page.
     */
    public function archive(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $page->update(['is_archived' => true]);

        return redirect()->route('pages.index')->with('success', 'Page archived successfully!');
    }

    /**
     * Restore the archived page.
     */
    public function restore(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $page->update(['is_archived' => false]);

        return back()->with('success', 'Page restored successfully!');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $page->delete(); // This will cascade delete child pages too

        return redirect()->route('pages.index')->with('success', 'Page deleted permanently!');
    }

    /**
     * Duplicate a page and its children.
     */
    public function duplicate(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $newPage = $this->duplicatePage($page);

        return redirect()->route('pages.show', $newPage)->with('success', 'Page duplicated successfully!');
    }

    /**
     * Generate breadcrumbs for a page.
     */
    private function generateBreadcrumbs(Page $page)
    {
        $breadcrumbs = [];
        $current = $page;
        
        while ($current->parent) {
            array_unshift($breadcrumbs, $current->parent);
            $current = $current->parent;
        }
        
        return $breadcrumbs;
    }

    /**
     * Recursively duplicate a page and its children.
     */
    private function duplicatePage(Page $page, $parentId = null)
    {
        // Create a copy of the page
        $newPage = $page->replicate();
        $newPage->parent_id = $parentId;
        $newPage->title = "Copy of " . $page->title;
        $newPage->save();
        
        // Duplicate all children
        foreach ($page->children as $child) {
            $this->duplicatePage($child, $newPage->id);
        }
        
        return $newPage;
    }
}