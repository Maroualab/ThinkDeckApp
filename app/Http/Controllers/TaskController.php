<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task = Auth::user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    /**
     * Toggle task completion status.
     */
    public function toggleStatus($id, Request $request)
    {
        $task = Auth::user()->tasks()->findOrFail($id);
        $task->completed = $request->completed;
        $task->save();

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

 
    public function destroy(Task $task)
    {
        // Ensure the authenticated user owns the task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Delete the task
        $task->delete();

        return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
    }
}
