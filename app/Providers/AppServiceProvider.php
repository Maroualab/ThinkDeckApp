<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Create a reusable function for getting sidebar data
        $getSidebarData = function() {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Get workspaces
                $workspaces = $user->workspaces()->get();
                
                // Get active workspace (from session or default)
                $activeWorkspaceId = session('active_workspace_id');
                $activeWorkspace = null;
                
                if ($activeWorkspaceId) {
                    $activeWorkspace = $workspaces->where('id', $activeWorkspaceId)->first();
                }
                
                // If no active workspace is found, use the default
                if (!$activeWorkspace) {
                    $activeWorkspace = $workspaces->where('is_default', true)->first();
                    
                    // If no default workspace, use the first one
                    if (!$activeWorkspace && $workspaces->count() > 0) {
                        $activeWorkspace = $workspaces->first();
                    }
                    
                    // Store in session if found
                    if ($activeWorkspace) {
                        session(['active_workspace_id' => $activeWorkspace->id]);
                    }
                }
                
                // Get recent pages and notes for the sidebar
                $recentPages = $activeWorkspace 
                    ? $activeWorkspace->pages()->latest()->take(3)->get()
                    : $user->pages()->latest()->take(3)->get();
                    
                $recentNotes = $activeWorkspace
                    ? $activeWorkspace->notes()->latest()->take(3)->get()
                    : $user->notes()->latest()->take(3)->get();
                    
                // Get combined recent items for dashboard
                $recentItems = $recentPages->merge($recentNotes)
                    ->sortByDesc('updated_at')
                    ->take(5);
                
                return compact('workspaces', 'activeWorkspace', 'recentPages', 'recentNotes', 'recentItems');
            }
            
            return [
                'workspaces' => collect(),
                'activeWorkspace' => null,
                'recentPages' => collect(),
                'recentNotes' => collect(),
                'recentItems' => collect(),
            ];
        };

        // Share data with views
        View::composer(['layouts.dashboard', 'partials.sidebar-navigation', 'dashboard'], function ($view) use ($getSidebarData) {
            $view->with($getSidebarData());
        });
    }
}