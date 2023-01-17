<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\AccessMaster;
use App\Models\MenuPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
        Schema::defaultStringLength(191);
        view()->composer('*', function ($menus) {
            $menus->with('menus', Menu::where('parent_id', '=', '0')->get());
        });
    }
}
