<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WorkspaceController extends Controller
{
    use AuthorizesRequests; 
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workspaces = Auth::user()->workspaces()->get();
        return view('workspaces.index', compact('workspaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workspaces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:50',
            'is_default' => 'boolean',
        ]);

        // If this is the default workspace, unset all other defaults
        if (!empty($validated['is_default'])) {
            Auth::user()->workspaces()->where('is_default', true)->update(['is_default' => false]);
        }
        
        // If this is the first workspace, make it default
        $isFirstWorkspace = Auth::user()->workspaces()->count() === 0;
        if ($isFirstWorkspace) {
            $validated['is_default'] = true;
        }
        
        $workspace = Auth::user()->workspaces()->create($validated);
        
        return redirect()->route('workspaces.show', $workspace)
            ->with('success', 'Workspace created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace)
    {
        $this->authorize('view', $workspace);
        
        $pages = $workspace->pages()->latest()->paginate(10);
        
        $notes = $workspace->notes()->latest()->paginate(10);
        
        return view('workspaces.show', compact('workspace', 'pages', 'notes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workspace $workspace)
    {
        $this->authorize('update', $workspace);
        return view('workspaces.edit', compact('workspace'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace)
    {
        $this->authorize('update', $workspace);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:50',
            'is_default' => 'boolean',
        ]);

        // If making this workspace the default, unset all other defaults
        if (!empty($validated['is_default']) && !$workspace->is_default) {
            Auth::user()->workspaces()->where('is_default', true)->update(['is_default' => false]);
        }
        
        $workspace->update($validated);
        
        return redirect()->route('workspaces.show', $workspace)
            ->with('success', 'Workspace updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace)
    {
        $this->authorize('delete', $workspace);
        
        // Check if it's the only workspace or the default workspace
        if (Auth::user()->workspaces()->count() === 1) {
            return back()->with('error', 'Cannot delete the only workspace.');
        }
        
        if ($workspace->is_default) {
            // Find another workspace to make default
            $newDefault = Auth::user()->workspaces()->where('id', '!=', $workspace->id)->first();
            $newDefault->update(['is_default' => true]);
        }
        
        // Note: We've set up nullOnDelete for workspace_id in pages and notes
        // so they'll remain but without a workspace
        $workspace->delete();
        
        return redirect()->route('workspaces.index')
            ->with('success', 'Workspace deleted successfully');
    }
    
    /**
     * Switch the active workspace.
     */
    public function switch(Workspace $workspace)
    {
        $this->authorize('view', $workspace);
        
        // Store the selected workspace in the session
        session(['active_workspace_id' => $workspace->id]);
        
        return redirect()->back()->with('success', "Switched to {$workspace->name} workspace");
    }
}
