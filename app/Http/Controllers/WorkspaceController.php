<?php

namespace App\Http\Controllers;

use App\Mail\inviteUserToWorkspace;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use PhpParser\Builder\Use_;

class WorkspaceController extends Controller
{
    use AuthorizesRequests; 
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        
        // Combine workspaces user owns and is a member of
        $OwnedWorkspaces = auth()->user()->workspaceOwner;
        $ContributeWorkspaces = auth()->user()->workspaces;
        $workspaces = $OwnedWorkspaces->concat($ContributeWorkspaces);
        // dd($workspaces);
        return view('workspaces.index', compact('workspaces','ContributeWorkspaces','OwnedWorkspaces'));
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
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:50',
        ]);

        $workspace=Workspace::create([
            'workspace_ref'=>uniqid('#WS-'),
            'owner_id'=>auth()->user()->id,
            'name'=>$validated['name'],
            'icon'=>$validated['icon'],
            'color'=>$validated['color']
        ]);
        
        return redirect()->route('workspaces.show', $workspace)
            ->with('success', 'Workspace created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace)
    {
        
        $pages = $workspace->pages()->latest()->paginate(10);
                
        return view('workspaces.show', compact('workspace', 'pages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workspace $workspace)
    {
        
        return view('workspaces.edit', compact('workspace'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace)
    {
        
        
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
        
        
        // Store the selected workspace in the session
        session(['active_workspace_id' => $workspace->id]);
        
        return redirect()->back()->with('success', "Switched to {$workspace->name} workspace");
    }
    public function join(Request $request){
        // If this is a GET request, decode the workspace_ref from the URL
        if($request->method()==='GET'){
            $request->merge(['workspace_ref' => urldecode($request->workspace_ref)]);
        }
        $validated=$request->validate([
            'workspace_ref'=>'required|exists:workspaces,workspace_ref'
        ]);
        
        $workspace=Workspace::where('workspace_ref',$validated['workspace_ref'])->first();
        
        
        
        // Check if user already owns or is a member of this workspace
        if ($workspace->owner_id === auth()->id() || $workspace->users->contains(auth()->id())) {
            return redirect()->back()->with('workspaceError', 'You are already a member of this workspace.');
        }
        
        // Add user to workspace members
        $workspace->users()->attach(auth()->id());
        
        return redirect()->route('workspaces.show', $workspace)
            ->with('success', 'You have joined the workspace successfully.');

    }

    public function workspacesUsers(Workspace $workspace){
        return view('workspaces.users',compact('workspace'));
    }

    public function removeUser(Workspace $workspace,User $user){
        $workspace->users()->detach($user);
        return redirect()->route('workspaces.users',$workspace)->with(['removed'=>"$user->name was removed from the workspace"]);
    }

    public function inviteUser(Workspace $workspace,Request $request){
        $validated=$request->validate([
            'email'=>'required|email',
        ]);
        Mail::to($validated['email'])->send(new inviteUserToWorkspace($workspace));

        return redirect()->route('workspaces.users',$workspace)->with(['success_invite'=>'invitation sent successfuly']);
    }

    public function acceptUser(Workspace $workspace , User $user){

    if($workspace->users->contains($user->id)){
        $workspace->users()->updateExistingPivot($user->id, ['is_allowed' => 'allowed']);
        
        return redirect()->back()->with(['approved'=>"$user->name was approved successfully"]);    
    }

    return redirect()->back()->with(['not_invited'=>"$user->name is not invited"]);    

    }

    public function rejectUser(Workspace $workspace , User $user){
        if($workspace->users->contains($user->id)){
            $workspace->users()->updateExistingPivot($user->id, ['is_allowed' => 'rejected']);
        return redirect()->back()->with(['rejected'=>"$user->name is rejected"]);    
        }
        return redirect()->back()->with(['not_invited'=>"$user->name is not invited"]);    
    
    }


}

