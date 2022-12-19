<?php

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Department\Department;
use App\Http\Livewire\DepartmentCategory\DepartmentCategoryList;
use App\Http\Livewire\Designation\CreateDesignation;
use App\Http\Livewire\Designation\Designation;
use App\Http\Livewire\Estimate\EstimatePrepare;
use App\Http\Livewire\EstimateProject\EstimateProject;
use App\Http\Livewire\Office\Office;
use App\Http\Livewire\Sor\Sor;
use App\Http\Livewire\UserType\UserType;
use Illuminate\Support\Facades\Artisan;
// Packages
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

//UI Pages Routs
Route::get('/', [HomeController::class, 'signin'])->name('auth.signin');
        // Route::get('designation', Designation::class)->name('designation');
        // Route::get('department', Department::class)->name("department");
        // Route::get('office', Office::class)->name('office');
        // Route::get('user-management', UserManagement::class)->name("user-management");
        // Route::get('user-type', UserType::class)->name("user-type");
        // Route::get('access-manager', AccessManager::class)->name("access-manager");
        // Route::get('access-type', AccessType::class)->name("access-type");
        // Route::get('roles',RolesManagement::class)->name("roles");
        // Route::get('menu',Menus::class)->name('menu');
        // Route::get('menu-permission',MenuPermission::class)->name('menu-permission');
        // Route::get('sor-category',SORCategory::class)->name('sor-category');
        // // Route::get('estimate-master',[EstimatePrepareController::class,'index'])->name('estimate-master.index');
        // Route::get('sor',Sor::class)->name('sor');
        // Route::get('userslist',[UsersController::class,'index'])->name('userslist.index');
        // Route::get('estimate-recommender',EstimateRecomender::class)->name('estimate-recommender');
        // Route::get('estimate-recommender/{id}',Test::class);
        // Route::get('estimate-project',EstimateProject::class)->name('estimate-project');
        // Route::get('sor-master',SorMaster::class)->name('sor-master');
        // Route::get('estimate-prepare',EstimatePrepar::class)->name("estimate-prepare");


Route::group(['middleware' => 'auth'], function () {
    // Permission Module
    Route::get('/role-permission',[RolePermission::class, 'index'])->name('role.permission.list');
    Route::resource('permission',PermissionController::class);
    Route::resource('role', RoleController::class);

    // Dashboard Routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Users Module
    Route::resource('users', UserController::class);

    Route::get('estimate-prepare',EstimatePrepare::class)->name('estimate-prepare');
    Route::get('estimate-project',EstimateProject::class)->name('estimate-project');
    Route::get('designation',Designation::class)->name('designation');
    Route::get('user-type', UserType::class)->name("user-type");
    Route::get('department', Department::class)->name("department");
    Route::get('department-category',DepartmentCategoryList::class)->name('department-category');
    Route::get('office', Office::class)->name('office');
    Route::get('sor',Sor::class)->name('sor');
    Route::view('/powergrid', 'powergrid-demo');

});

//App Details Page => 'Dashboard'], function() {
Route::group(['prefix' => 'menu-style'], function() {
    //MenuStyle Page Routs
    Route::get('horizontal', [HomeController::class, 'horizontal'])->name('menu-style.horizontal');
    Route::get('dual-horizontal', [HomeController::class, 'dualhorizontal'])->name('menu-style.dualhorizontal');
    Route::get('dual-compact', [HomeController::class, 'dualcompact'])->name('menu-style.dualcompact');
    Route::get('boxed', [HomeController::class, 'boxed'])->name('menu-style.boxed');
    Route::get('boxed-fancy', [HomeController::class, 'boxedfancy'])->name('menu-style.boxedfancy');
});

//App Details Page => 'special-pages'], function() {
Route::group(['prefix' => 'special-pages'], function() {
    //Example Page Routs
    Route::get('billing', [HomeController::class, 'billing'])->name('special-pages.billing');
    Route::get('calender', [HomeController::class, 'calender'])->name('special-pages.calender');
    Route::get('kanban', [HomeController::class, 'kanban'])->name('special-pages.kanban');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('special-pages.pricing');
    Route::get('rtl-support', [HomeController::class, 'rtlsupport'])->name('special-pages.rtlsupport');
    Route::get('timeline', [HomeController::class, 'timeline'])->name('special-pages.timeline');
});

//Widget Routs
Route::group(['prefix' => 'widget'], function() {
    Route::get('widget-basic', [HomeController::class, 'widgetbasic'])->name('widget.widgetbasic');
    Route::get('widget-chart', [HomeController::class, 'widgetchart'])->name('widget.widgetchart');
    Route::get('widget-card', [HomeController::class, 'widgetcard'])->name('widget.widgetcard');
});

//Maps Routs
Route::group(['prefix' => 'maps'], function() {
    Route::get('google', [HomeController::class, 'google'])->name('maps.google');
    Route::get('vector', [HomeController::class, 'vector'])->name('maps.vector');
});

//Auth pages Routs
Route::group(['prefix' => 'auth'], function() {
    Route::get('signin', [HomeController::class, 'signin'])->name('auth.signin');
    Route::get('signup', [HomeController::class, 'signup'])->name('auth.signup');
    Route::get('confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
    Route::get('lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
    Route::get('recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');
    Route::get('userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
});

//Error Page Route
Route::group(['prefix' => 'errors'], function() {
    Route::get('error404', [HomeController::class, 'error404'])->name('errors.error404');
    Route::get('error500', [HomeController::class, 'error500'])->name('errors.error500');
    Route::get('maintenance', [HomeController::class, 'maintenance'])->name('errors.maintenance');
});


//Forms Pages Routs
Route::group(['prefix' => 'forms'], function() {
    Route::get('element', [HomeController::class, 'element'])->name('forms.element');
    Route::get('wizard', [HomeController::class, 'wizard'])->name('forms.wizard');
    Route::get('validation', [HomeController::class, 'validation'])->name('forms.validation');
});


//Table Page Routs
Route::group(['prefix' => 'table'], function() {
    Route::get('bootstraptable', [HomeController::class, 'bootstraptable'])->name('table.bootstraptable');
    Route::get('datatable', [HomeController::class, 'datatable'])->name('table.datatable');
});

//Icons Page Routs
Route::group(['prefix' => 'icons'], function() {
    Route::get('solid', [HomeController::class, 'solid'])->name('icons.solid');
    Route::get('outline', [HomeController::class, 'outline'])->name('icons.outline');
    Route::get('dualtone', [HomeController::class, 'dualtone'])->name('icons.dualtone');
    Route::get('colored', [HomeController::class, 'colored'])->name('icons.colored');
});

//Extra Page Routs
// Route::get('privacy-policy', [HomeController::class, 'privacypolicy'])->name('pages.privacy-policy');
// Route::get('terms-of-use', [HomeController::class, 'termsofuse'])->name('pages.term-of-use');
