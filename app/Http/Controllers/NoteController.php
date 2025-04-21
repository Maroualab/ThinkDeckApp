<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $notes = Note::paginate(10); // 10 items per page
        
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
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
        
        return view('notes.create', compact('workspace'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'workspace_id' => 'nullable|exists:workspaces,id',
        ]);

        // If no workspace_id is specified, use the active workspace from session
        if (!isset($validated['workspace_id']) && session('active_workspace_id')) {
            $validated['workspace_id'] = session('active_workspace_id');
        }

        $note = Auth::user()->notes()->create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'icon' => $validated['icon'] ?? '📝',
            'workspace_id' => $validated['workspace_id'],
        ]);

        return redirect()->route('notes.show', $note)->with('success', 'Note created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        // Check if the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        // Check if the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        // Check if the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'workspace_id' => 'nullable|exists:workspaces,id',
        ]);

        // If no workspace_id is specified, use the active workspace from session
        if (!isset($validated['workspace_id']) && session('active_workspace_id')) {
            $validated['workspace_id'] = session('active_workspace_id');
        }

        $note->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'icon' => $validated['icon'] ?? $note->icon,
            'workspace_id' => $validated['workspace_id'],
        ]);

        // Use flash only once
        return redirect()->route('notes.show', $note)->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        // Check if the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $note->delete();

        // Use flash only once
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }
}