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

        $getSidebarData = function () {
            if (Auth::check()) {
                $user = Auth::user();
                $workspaces = $user->workspaces()->get();

                // Fallback to first workspace if none is active
                $activeWorkspace = $workspaces->firstWhere('id', session('active_workspace_id'))
                    ?? $workspaces->where('is_default', true)->first()
                    ?? $workspaces->first();

                // Always ensure an active workspace is set
                if ($activeWorkspace && !session('active_workspace_id')) {
                    session(['active_workspace_id' => $activeWorkspace->id]);
                }

                // Get recent items FROM ACTIVE WORKSPACE ONLY
                $recentPages = $activeWorkspace
                    ? $activeWorkspace->pages()->latest('updated_at')->take(5)->get()
                    : collect();

                $recentNotes = $activeWorkspace
                    ? $activeWorkspace->notes()->latest('updated_at')->take(5)->get()
                    : collect();

                return compact('workspaces', 'activeWorkspace', 'recentPages', 'recentNotes');
            }

            return ['workspaces' => collect(), 'activeWorkspace' => null, 'recentPages' => collect(), 'recentNotes' => collect()];
        };

        // Share data with views
        View::composer(['layouts.dashboard', 'partials.sidebar', 'partials.sidebar-navigation', 'dashboard'], function ($view) use ($getSidebarData) {
            $view->with($getSidebarData());
        });
    }
}