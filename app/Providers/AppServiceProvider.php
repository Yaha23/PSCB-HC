<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
    Schema::defaultStringLength(191);
    Paginator::useBootstrap();

    // 🔥 VARIABLE GLOBAL $base
    View::composer('*', function ($view) {

        $user = Auth::user();

        if ($user && $user->hasRole('admin')) {
            $base = 'admin';
        } elseif ($user && $user->hasRole('asistente')) {
            $base = 'asistente';
        } elseif ($user && $user->hasRole('medico')) {
            $base = 'medico';
        } else {
            $base = '';
        }

        $view->with('base', $base);
    });
}
}

