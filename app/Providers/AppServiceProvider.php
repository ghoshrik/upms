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
            // dd(Menu::where(['title','Estimate Prepare'])->orderBy('piority')->get());
            // $m = Menu::where('parent_id', '=', '0')->orderBy('piority')->get();
            // dd($m);
            // dd($m[0]->permission_or_role);
            $menus->with('menus', Menu::where('parent_id', '=', '0')->orderBy('piority')->get());
        });
    }
}
