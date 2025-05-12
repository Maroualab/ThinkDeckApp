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

    public function index(Request $request)
    {
        $notes = Auth::user()->notes()
                    ->latest()
                    ->paginate(10);
        
        return view('notes.index', compact('notes'));
    }
   


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $workspaceId = $request->workspace_id;
        $workspace = null;
        
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
            'icon' => 'required|string',
        ]);

        $note = Auth::user()->notes()->create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? '',
            'icon' => $validated['icon'],
        ]);

        return redirect()->route('notes.show', $note)
            ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
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
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
        ]);

     
        $note->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'icon' => $validated['icon'] ?? $note->icon,
        ]);

        return redirect()->route('notes.show', $note)->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }
}