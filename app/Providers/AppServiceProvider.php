<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
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
        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole('Super Admin') ? true : null;
        // });
        Schema::defaultStringLength(191);
        view()->composer('*', function ($menus) {
            if (Session::has('menus')) {
                $menusData = Session::get('menus');
            } else {
                $menusData = Menu::where('parent_id', '=', '0')->orderBy('piority')->get();
                Session::put('menus', $menusData);
            }
            $menus->with('menus', $menusData);
        });
        DB::listen(function ($query) {
            File::append(
                storage_path('/logs/query.log'),
                '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
            );
        });

    }

}
