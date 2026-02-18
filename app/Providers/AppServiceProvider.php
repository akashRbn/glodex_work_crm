<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
       View::composer('layouts.partials.sidebar-admin', function ($view) {
            
            // Pending Agent users
            $pendingAgentUser = User::where('user_type', 2)->where('user_status', 1)->count();

            // Active Agent users 
            $activeAgentUser = User::where('user_type', 2)
                                ->where('user_status', 2)
                                ->count();
            // pending student users 
            $pendingStudenttUser = User::where('user_type', 3)
                                ->where('user_status', 1)
                                ->count();

            $view->with([
                'pendingAgentUser' => $pendingAgentUser,
                'activeAgentUser' => $activeAgentUser,
                'pendingStudenttUser' => $pendingStudenttUser,
            ]);
        });

        Paginator::useBootstrap();
    }
}
