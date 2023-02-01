<?php

namespace App\Http\Controllers\Security;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        // dd($user->hasRole('dept-admin'));
        // dd($user->givePermissionsTo('create-sor'));
        // dd($user->can('create-sor'));
        if($user->hasRole('dept-admin'))
        {
            echo "exists";
        }
        else
        {
            echo "exists false";
        }


        // $user_permission = Permission::where('slug','create-menu')->first();//super admin
		// $admin_permission = Permission::where('slug', 'create-sor')->first();//dept admin

        //RoleTableSeeder.php
		// $user_role = new Role();
        // $user_role->name = ' Super Admin';
		// $user_role->slug = 'super-admin';
		// $user_role->save();
		// $user_role->permissions()->attach($user_permission);

		// $admin_role = new Role();
		// $admin_role->slug = 'dept-admin';
		// $admin_role->name = 'Dept Admin';
		// $admin_role->save();
		// $admin_role->permissions()->attach($admin_permission);


        // $user_role = Role::where('slug','super-admin')->first();
		// $admin_role = Role::where('slug', 'dept-admin')->first();

        // $user_role->permissions()->attach($user_permission); // super admin
        // $admin_role->permissions()->attach($admin_permission);//dept admin



        //rolepermission
		// $user_permission->roles()->attach($user_role);
		// $admin_permission->roles()->attach($admin_role);


        // $super_admin = User::where('username','admin')->first();
        // $super_admin->roles()->attach($user_role);
        // $super_admin->permissions()->attach($user_permission);

        // $dept_admin = User::where('username','agri_department_admin')->first();
        // $dept_admin->roles()->attach($admin_role);
		// $dept_admin->permissions()->attach($admin_permission);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $view = view('role-permission.form-permission')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //code here
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //code here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //code here
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //code here
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //code here
    }
}
