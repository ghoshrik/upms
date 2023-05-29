<?php

// Controllers

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Aafs\AafsProjects;
use App\Http\Livewire\AccessManager\AccessManager;
use App\Http\Livewire\AccessType\AccessType;
use App\Http\Livewire\Aoc\Aocs;
use App\Http\Livewire\AssignDeptAdmin\AssignDepartmentAdmin;
use App\Http\Livewire\AssignOfficeAdmin\AssignOfficeAdmin;
use App\Http\Livewire\AssignToAnotherOffice\AssignToAnotherOffice;
use App\Http\Livewire\Composersor\ComposerSors;
use App\Http\Livewire\DepartmentCategory\DepartmentCategoryList;
// use App\Http\Livewire\TestALL\TestSearch;
use App\Http\Livewire\Department\Department;
use App\Http\Livewire\Designation\Designation;
use App\Http\Livewire\EstimateForwarder\EstimateForwarder;
use App\Http\Livewire\EstimateProject\EstimateProject;
use App\Http\Livewire\EstimateRecomender\EstimateRecomender;
use App\Http\Livewire\Estimate\EstimatePrepare;
use App\Http\Livewire\MenuManagement\MenuManagement;
// use App\Http\Livewire\Permission\Permissions;
use App\Http\Livewire\Milestone\Milestones;
use App\Http\Livewire\Office\Office;
use App\Http\Livewire\Permission\Permission;
use App\Http\Livewire\RateAnalysis\RateAnalysis;
use App\Http\Livewire\Report\MisReport;
use App\Http\Livewire\QuantityEvaluation\QuantityEvaluation;
use App\Http\Livewire\Roles\AssignRole\AssignRole;
use App\Http\Livewire\Roles\Roles;
use App\Http\Livewire\Setting\SettingLists;
use App\Http\Livewire\Sor\CompojitSor\CompojitSor;
use App\Http\Livewire\Sorapprove\SorApprovers;
use App\Http\Livewire\Sor\Sor;
use App\Http\Livewire\Tender\Tenders;
use App\Http\Livewire\Unitsmaster\UnitsMaster;
use App\Http\Livewire\UserManagement\UserManagement;
use App\Http\Livewire\UserType\UserType;
use App\Http\Livewire\VendorRegs\VendorList;
use App\Models\ComposerSor;
// Packages
use App\Models\User;
use App\Models\UsersHasRoles;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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

require __DIR__ . '/auth.php';
// Route::get('set-role', function () {
//     $users = User::where('user_type', 4)->get();
//     foreach ($users as $user) {
//         $user->syncRoles('Office Admin');
//     }
//     $user = Auth::user()->id;
//     $user = User::find($user)->first();
//     $user = User::where('id',$user)->first();
//     $user->syncRoles("Department Admin");
// });

// Route::get('/', [HomeController::class, 'signin'])->name('auth.signin');
// Route::get('otp-send/{id}', [HomeController::class, 'otpView'])->name('auth.otp');

Route::get('/', [AuthController::class, 'showLoginPage'])->name('auth.signin');
Route::post('userlogin', [AuthController::class, 'Userlogin'])->name('auth.login');
Route::get('verify/{user_id}', [AuthController::class, 'verifyOTP'])->name('auth.verify');
Route::post('otp/verify', [AuthController::class, 'LoginWithOTP'])->name('otp.login');
Route::get('resend-otp/{user_id}', [AuthController::class, 'resendOTP'])->name('otp.resend');

Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::group(['middleware' => 'auth', 'check.otp'], function () {

        Route::post('logout', [AuthController::class, 'destroy'])->name('auth.destroy');
        // Permission Module
        // Route::get('/role-permission',[RolePermission::class, 'index'])->name('role.permission.list');
        // Route::resource('permission',PermissionController::class);
        // Route::resource('role', RoleController::class);

        // Dashboard Routes
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');



        //state Admin

        Route::group(['middleware' => ['role:State Admin']], function () {
            Route::get('department', Department::class)->name("department");
            Route::get('assign-dept-admin', AssignDepartmentAdmin::class)->name('assign-dept-admin');
            Route::get('mis-report', MisReport::class)->name('mis-report');
        });
        Route::group(['middleware' => ['role:State Admin|Department Admin|Office Admin']], function () {
            Route::get('user-management', UserManagement::class)->name('user-management');
        });


        //Department Admin
        Route::group(['middleware' => ['role:Department Admin']], function () {
            Route::get('designation', Designation::class)->name('designation');
            Route::get('office', Office::class)->name('office');
            Route::get('assign-office-admin', AssignOfficeAdmin::class)->name('assign-office-admin');
            Route::get('sor-approver', SorApprovers::class)->name('sor-approver');
            Route::get('unit-master', UnitsMaster::class)->name('unit-master');
            Route::get('department-category', DepartmentCategoryList::class)->name('department-category');
        });

        //Office Admin
        Route::group(['middleware' => ['role:Office Admin']], function () {
            Route::get('assign-role', AssignRole::class)->name('assign-role');
            Route::get('milestones', Milestones::class)->name('milestones');
            Route::get('vendors', VendorList::class)->name('vendors');
            Route::get('tenders', Tenders::class)->name('tenders');
            Route::get('aafs-project', AafsProjects::class)->name('aafs-project');
            Route::get('aoc', Aocs::class)->name('aoc');
        });

        // Office User
        Route::group(['middleware' => ['role:Estimate Recommender (ER)']], function () {
            Route::get('estimate-recommender', EstimateRecomender::class)->name('estimate-recommender');
        });


        Route::group(['middleware' => ['role:Estimate Preparer (EP)']], function () {
            Route::get('estimate-prepare', EstimatePrepare::class)->name('estimate-prepare');
        });
        Route::group(['middleware' => ['role:Estimate Forwarder (EF)']], function () {
            Route::get('estimate-forwarder', EstimateForwarder::class)->name('estimate-forwarder');
        });

        Route::group(['middleware' => ['role:Project Estimate (EP)']], function () {
            Route::get('estimate-project', EstimateProject::class)->name('estimate-project');
        });

        Route::group(['middleware' => ['role:SOR Preparer']], function () {
            Route::get('prepare-sor', Sor::class)->name('prepare-sor');
            Route::get('composit-sor', ComposerSors::class)->name('composit-sor');
        });

        Route::get('user-type', UserType::class)->name("user-type");
        Route::get('access-manager', AccessManager::class)->name('access-manager');
        Route::get('access-type', AccessType::class)->name('access-type');
        Route::get('menu-manager', MenuManagement::class)->name('menu-manager');

        Route::get('rate-analysis', RateAnalysis::class)->name('rate-analysis');


        // Route::get('aafs-project',ProjectList::class)->name('aafs-project');
        Route::get('roles', Roles::class)->name('roles');
        Route::get('permissions', Permission::class)->name('permissions');

        // Route::get('vendors',VendorList::class)->name('vendors');

        // Route::get('aafs-project', AafsProjects::class)->name('aafs-project');
        // Route::get('aoc', Aocs::class)->name('aoc');
        // Route::get('tenders', Tenders::class)->name('tenders');
        // Route::get('assign-office-admin', AssignOfficeAdmin::class)->name('assign-office-admin');
        Route::get('assign-another-office', AssignToAnotherOffice::class)->name('assign-another-office');
        // Route::get('assign-dept-admin', AssignDepartmentAdmin::class)->name('assign-dept-admin');
        // Route::get('sor-approver', SorApprovers::class)->name('sor-approver');
        // Route::get('unit-master', UnitsMaster::class)->name('unit-master');
        // Route::get('qty-analysis', AnalysisList::class)->name('qty-analysis');

        Route::get('assign-another-office', AssignToAnotherOffice::class)->name('assign-another-office');





        // Route::prefix('admin',function(){
        Route::get('admin/settings', SettingLists::class)->name('admin.settings');
        // });

        Route::get('change-role/{id}', function ($id) {
            if (UsersHasRoles::where([['user_id', Auth::user()->id], ['role_id', $id]])->first()) {
                $selectedRole = Role::find($id);
                Auth::user()->syncRoles($selectedRole->name);
                return redirect('/dashboard');
            } else {
                return redirect('/dashboard');
            }
        })->name('change-role');
    });
});




//App Details Page => 'Dashboard'], function() {
Route::group(['prefix' => 'menu-style'], function () {
    //MenuStyle Page Routs
    Route::get('horizontal', [HomeController::class, 'horizontal'])->name('menu-style.horizontal');
    Route::get('dual-horizontal', [HomeController::class, 'dualhorizontal'])->name('menu-style.dualhorizontal');
    Route::get('dual-compact', [HomeController::class, 'dualcompact'])->name('menu-style.dualcompact');
    Route::get('boxed', [HomeController::class, 'boxed'])->name('menu-style.boxed');
    Route::get('boxed-fancy', [HomeController::class, 'boxedfancy'])->name('menu-style.boxedfancy');
});

//App Details Page => 'special-pages'], function() {
// Route::group(['prefix' => 'special-pages'], function() {
//     //Example Page Routs
//     Route::get('billing', [HomeController::class, 'billing'])->name('special-pages.billing');
//     Route::get('calender', [HomeController::class, 'calender'])->name('special-pages.calender');
//     Route::get('kanban', [HomeController::class, 'kanban'])->name('special-pages.kanban');
//     Route::get('pricing', [HomeController::class, 'pricing'])->name('special-pages.pricing');
//     Route::get('rtl-support', [HomeController::class, 'rtlsupport'])->name('special-pages.rtlsupport');
//     Route::get('timeline', [HomeController::class, 'timeline'])->name('special-pages.timeline');
// });

//Widget Routs
// Route::group(['prefix' => 'widget'], function() {
//     Route::get('widget-basic', [HomeController::class, 'widgetbasic'])->name('widget.widgetbasic');
//     Route::get('widget-chart', [HomeController::class, 'widgetchart'])->name('widget.widgetchart');
//     Route::get('widget-card', [HomeController::class, 'widgetcard'])->name('widget.widgetcard');
// });

//Maps Routs
// Route::group(['prefix' => 'maps'], function() {
//     Route::get('google', [HomeController::class, 'google'])->name('maps.google');
//     Route::get('vector', [HomeController::class, 'vector'])->name('maps.vector');
// });

//Auth pages Routs
Route::group(['prefix' => 'auth'], function () {
    Route::get('signup', [HomeController::class, 'signup'])->name('auth.signup');
    Route::get('confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
    Route::get('lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
    Route::get('recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');
    Route::get('userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
});

//Error Page Route
Route::group(['prefix' => 'errors'], function () {
    Route::get('error404', [HomeController::class, 'error404'])->name('errors.error404');
    Route::get('error500', [HomeController::class, 'error500'])->name('errors.error500');
    Route::get('maintenance', [HomeController::class, 'maintenance'])->name('errors.maintenance');
});

//Forms Pages Routs
// Route::group(['prefix' => 'forms'], function() {
//     Route::get('element', [HomeController::class, 'element'])->name('forms.element');
//     Route::get('wizard', [HomeController::class, 'wizard'])->name('forms.wizard');
//     Route::get('validation', [HomeController::class, 'validation'])->name('forms.validation');
// });

//Table Page Routs
// Route::group(['prefix' => 'table'], function() {
//     Route::get('bootstraptable', [HomeController::class, 'bootstraptable'])->name('table.bootstraptable');
//     Route::get('datatable', [HomeController::class, 'datatable'])->name('table.datatable');
// });

//Icons Page Routs
// Route::group(['prefix' => 'icons'], function() {
//     Route::get('solid', [HomeController::class, 'solid'])->name('icons.solid');
//     Route::get('outline', [HomeController::class, 'outline'])->name('icons.outline');
//     Route::get('dualtone', [HomeController::class, 'dualtone'])->name('icons.dualtone');
//     Route::get('colored', [HomeController::class, 'colored'])->name('icons.colored');
// });

//Extra Page Routs
// Route::get('privacy-policy', [HomeController::class, 'privacypolicy'])->name('pages.privacy-policy');
// Route::get('terms-of-use', [HomeController::class, 'termsofuse'])->name('pages.term-of-use');

//clear cache url
Route::get('cache-clear', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return 'Routes cache has been cleared';
});
//maintance mode enable
Route::get('maintance', function () {
    Artisan::call('down --render="errors::maintenance"');
    return redirect('/');
});
//Live mode
Route::get('live', function () {
    Artisan::call('up');
    return redirect('/');
});
