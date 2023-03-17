<?php

namespace Database\Seeders;

use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'title'=>'Dashboard',
                'parent_id'=>0,
                'icon'=>'home'
                ,'link'=>'dashboard'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'dashboard'
                ,'piority'=>1,
            ],
            [
                'title'=>'Designation',
                'parent_id'=>0,
                'icon'=>'user'
                ,'link'=>'designation'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create designation,edit designation'
                ,'piority'=>5,
            ],
            [
                'title'=>'Department',
                'parent_id'=>0,
                'icon'=>'network'
                ,'link'=>'department'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create department,edit department'
                ,'piority'=>4,
            ],
            [
                'title'=>'User Management ',
                'parent_id'=>0,
                'icon'=>'users'
                ,'link'=>'user-management'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create user,edit user'
                ,'piority'=>7,
            ],
            [
                'title'=>'Office',
                'parent_id'=>0,
                'icon'=>'briefcase'
                ,'link'=>'office'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create office,edit office'
                ,'piority'=>6,
            ],
            [
                'title'=>'User Type',
                'parent_id'=>0,
                'icon'=>'network'
                ,'link'=>'user-type'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create userType,edit userType'
                ,'piority'=>2,
            ],
            [
                'title'=>'Access Manager',
                'parent_id'=>0,
                'icon'=>'key'
                ,'link'=>'access-manager'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create accessManager,edit accessManager'
                ,'piority'=>8,
            ],
            [
                'title'=>'Access Type',
                'parent_id'=>0,
                'icon'=>'key'
                ,'link'=>'access-type'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create accessType,edit accessType'
                ,'piority'=>3,
            ],
            [
                'title'=>'Roles',
                'parent_id'=>0,
                'icon'=>'finger-print'
                ,'link'=>'roles'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create roles'
                ,'piority'=>NULL,
            ],
            [
                'title'=>'Menu',
                'parent_id'=>0,
                'icon'=>'menu'
                ,'link'=>'menu-manager'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create menu,edit menu'
                ,'piority'=>NULL,
            ],
            [
                'title'=>'Prepare SOR',
                'parent_id'=>0,
                'icon'=>'layers'
                ,'link'=>'prepare-sor'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create Prepare SOR,edit Prepare SOR'
                ,'piority'=>11,
            ],
            [
                'title'=>'Estimate Prepare',
                'parent_id'=>0,
                'icon'=>'puzzle'
                ,'link'=>'estimate-prepare'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create estimatePrepare,edit estimatePrepare'
                ,'piority'=>NULL,
            ],
            [
                'title'=>'SOR Category',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'sor-category'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create sorCategory,edit sorCategory'
                ,'piority'=>10,
            ],
            [
                'title'=>'Project Estimate',
                'parent_id'=>0,
                'icon'=>'layers'
                ,'link'=>'estimate-project'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create projectEstimate,edit projectEstimate'
                ,'piority'=>25,
            ],
            [
                'title'=>'Estimate Recommender',
                'parent_id'=>0,
                'icon'=>'layers'
                ,'link'=>'estimate-recommender'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create estimateRecommender,edit estimateRecommender'
                ,'piority'=>26,
            ],
            [
                'title'=>'Department Category',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'department-category'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create departmentCategory,edit departmentCategory'
                ,'piority'=>9,
            ],
            [
                'title'=>'Estimate Forwarder',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'estimate-forwarder'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'verify estimateForwarder'
                ,'piority'=>27,
            ],
            [
                'title'=>'Milestone',
                'parent_id'=>0,
                'icon'=>'flag'
                ,'link'=>'milestones'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create milestone,edit milestone'
                ,'piority'=>12,
            ],
            [
                'title'=>'Vendors',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'vendors'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create vendors,edit vendors'
                ,'piority'=>13,
            ],
            [
                'title'=>'AAFS Project',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'aafs-project'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create aafs-projects,edit aafs-projects'
                ,'piority'=>15,
            ],
            [
                'title'=>'Aoc',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'aoc'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create aoc,edit aoc'
                ,'piority'=>16,
            ],
            [
                'title'=>'Tender Information',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'tenders'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create tender,edit tender'
                ,'piority'=>14,
            ],
            [
                'title'=>'Assign Office Admin',
                'parent_id'=>0,
                'icon'=>'list'
                ,'link'=>'assign-office-admin'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create assignOfficeAdmin,edit assignOfficeAdmin'
                ,'piority'=>6,
            ],
                [
                    'title'=>'Assign Department Admin',
                'parent_id'=>0,
                'icon'=>'check'
                ,'link'=>'assign-dept-admin'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'create assignDeptAdmin'
                ,'piority'=>7,
                ],
            [
                'title'=>'SOR Approver',
                'parent_id'=>0,
                'icon'=>'check'
                ,'link'=>'sor-approver'
                ,'link_type'=>'route'
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'permission'=>'sor approver'
                ,'piority'=>NULL,
            ],
        ];
        foreach($menus as $menu)
        {
            Menu::create($menu);
        }
    }
}
