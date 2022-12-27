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
        // if (Auth::user()->user_type != 1) {
        //     view()->composer('*', function ($side_menu) {
        //         $side_menu->with('side_menu', MenuPermission::join('menus', 'menu_permissions.menu_id', '=', 'menus.id')->where('parent_id', '=', '0')
        //         ->where('userType_id', '=', Auth::user()->user_type)
        //         ->get());
        //         dd($side_menu);
        //     });

        //     view()->composer('*', function ($accessPermission) {
        //         $accessPermission->with('accessPermission', AccessMaster::join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->join('menus', 'access_types.menu_id', '=', 'menus.id')->join('users', 'access_masters.user_id', '=', 'users.id')->where('user_id', '=', Auth::user()->id)->get());
        //     });

        // }


        // view()->with('side_menu',MenuPermission::join('menus','menu_permissions.menu_id','=','menus.id')->where('parent_id','=','0')->get());
    }
}
