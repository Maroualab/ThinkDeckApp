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
        View::composer('layouts.dashboard', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Get recent pages
                $recentPages = $user->pages()
                    ->latest()
                    ->take(3)
                    ->get();
                
                // Get recent notes
                $recentNotes = $user->notes()
                    ->latest()
                    ->take(3)
                    ->get();
                
                // Get combined recent items for dashboard
                $recentItems = $user->pages()
                    ->latest()
                    ->take(5)
                    ->get()
                    ->merge($user->notes()->latest()->take(5)->get())
                    ->sortByDesc('updated_at')
                    ->take(5);
                
                $view->with(compact('recentPages', 'recentNotes', 'recentItems'));
            }
        });
    }
}
