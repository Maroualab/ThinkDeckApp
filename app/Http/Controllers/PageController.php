<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
   
    /**
     * Display a listing of the pages.
     */
    public function index()
    {
        $perPage = 15;

        $pages = Auth::user()->pages()
                    ->where('workspace_id', null)
                    ->latest()
                    ->paginate($perPage); 

        $favorites = Auth::user()->pages()
                    ->where('is_favorite', true)
                    ->where('is_archived', false)
                    ->latest()
                    ->get(); 

        return view('pages.index', compact('pages', 'favorites'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(Request $request)
    {
       return view('pages.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'required|string|max:10',
            'workspace_id'=> 'nullable|exists:workspaces,id'
        ]);

        $page = Page::create([
            'user_id'=>auth()->user()->id,
            'workspace_id'=>$validated['workspace_id'],
            'title'=>$validated['title'],
            'content'=>$validated['content'],
            'icon'=>$validated['icon'],
        ]);

        return redirect()->route('pages.show', $page)
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        if ($page->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        
        return view('pages.show', compact('page'));
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
            'is_favorite' => 'boolean',
            'is_template' => 'boolean',
        ]);

        $page->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? $page->content,
            'icon' => $validated['icon'] ?? $page->icon,
            'is_favorite' => isset($validated['is_favorite']) ? $validated['is_favorite'] : $page->is_favorite,
            'is_template' => isset($validated['is_template']) ? $validated['is_template'] : $page->is_template,
        ]);

        return redirect()->route('pages.show', $page)->with('success', 'Page updated successfully!');
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

        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted permanently!');
    }

    public function dashboard() {
        $recentPages = auth()->user()->pages()->orderBy('created_at', 'DESC')->paginate(3);
        $recentNotes = auth()->user()->notes()->orderBy('created_at', 'DESC')->paginate(3);
        $OwnedWorkspaces = auth()->user()->workspaceOwner()->orderBy('created_at', 'DESC')->paginate(3);
        $ContributeWorkspaces = auth()->user()->workspaces;
       
        return view('dashboard', compact('recentPages', 'recentNotes', 'OwnedWorkspaces', 'ContributeWorkspaces'));
    }
}
