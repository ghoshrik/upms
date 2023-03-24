<?php

return [
    'designation'=>[
        'title'=>'Designation',
        'title_singulars'=>'Designations',
        'create_btn_name'=>'Add New Designation',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'designation_name'=>'Designation Name',
            'status'=>'Status',
            'actions'=>'Actions'
        ],
    ],
    'department'=>[
        'title'=>'Department',
        'title_singular'=>'Departments',
        'create_btn_name'=>'Add New Department',
        'create_msg'=>'Department Created Successfully!!',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'department_name'=>'Department Name',
            'department_code'=>'Department Code',
            'status'=>'Status',
            'actions'=>'Actions'
        ],
    ],
    'office'=>[
        'title'=>'Office',
        'title_singular'=>'Offices',
        'create_btn_name'=>'Add Office',
        'create_msg'=>'Office Created Successfully!!',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'office_name'=>'Office Name',
            'office_district'=>'District',
            'area'=>'Area',
            'office_department'=>'Department',
            'block_name'=>'Block Name',
            'gp_name'=>'GP Name',
            'urban_body_name'=>'Urban Body Name',
            'word_no'=>'Ward No.',
            'office_address'=>'Office Address',
            'status'=>'Status',
            'actions'=>'Actions'
        ],
    ],
    'user_type'=>[
        'title'=>'User Type',
        'title_singular'=>'User Types',
        'create_btn_name'=>'Add User Type Name',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'name'=>' User Type Name',
            'status'=>'Status',
            'actions'=>'Actions',
        ],
    ],
    'user-management'=>[
        'title'=>'Users Management',
        'title_singulars'=>'Users Managements',
        'create_btn_name'=>'Add new Users',
        'create_msg'=>'New User created successfully',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'employee_id'=>'Employee ID',
            'employee_name'=>'Employee Name(User Name)',
            'office_name'=>'Office Name',
            'username'=>'Login Id',
            'designation'=>'Designation',
            'department'=>'Department',
            'user_type'=>'User Type',
            'password'=>'Password',
            'conf_pass'=>'Confirm Password',
            'status'=>'Status',
            'actions'=>'Actions',
        ],
    ],
    'access-manager'=>[
        'title'=>'Access Manager',
        'title_singular'=>'Access Managers',
        'create_btn_name'=>'Add New Access',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'title'=>'Access Management',
            'title_singulars'=>'Access Managements',
            'user_name'=>'User Name',
            'department'=>'Department',
            'designation'=>'Designation',
            'office'=>'Office',
            'access_type'=>'Access Type',
            'status'=>'Status',
            'actions'=>'Actions',
        ],
    ],
    'access-type'=>[
        'title'=>'Access Type',
        'title_singulars'=>'Access_types',
        'create_btn'=>'create_access_type',
        'create_msg'=>'New Aceess Type Created!',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'name'=>'Access Type Name',
            'actions'=>'Actions',
            'status'=>'Status'
        ],
    ],
    'sor'=>[
        'title'=>'SOR List',
        'title_singular'=>'SOR Lists',
        'create_btn_name'=>'Add New Sor',
        'create_msg'=>'SOR Created Successfully!!',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'item_number'=>'Item Number',
            'department'=>'Department',
            'description'=>'Description',
            'dept_category'=>'Department Category',
            'unit'=>'Unit',
            'cost'=>'Cost',
            'version'=>'Version',
            'effect_from'=>'From Date',
            'effect_to'=>'To Date',
            'date'=>'Date',
            'action'=>'Actions'
        ],
    ],
    'sor-approver'=>[
        'title'=>'SOR Approver List',
        'title_singular'=>'SOR Approver Lists',
        'create_msg'=>'SOR Approved',
        // 'fields'=>[
        //     'id'=>'ID',
        //     'id_helper'=>'#',
        //     'name'=>'Name',
        //     'email'=>'Email',
        //     'phone'=>'Phone',
        //     'address'=>'Address',
        //     'action'=>'Actions'
        // ],
    ],
    'dept_category'=>[
        'title'=>'Department Category',
        'title_singular'=>'Department Categories',
        'create_btn_name'=>'Add New Category',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'dept'=>'Department Name',
            'category'=>'Category',
            'action'=>'Actions'
        ],
    ],
    'estimate'=>[
        'title'=>'Estimate Prepare',
        'title_singular'=>'Estimate Prepares',
        'title_name'=>'Item Specific Estimated',
        'add_button'=>'Add New Estimate Prepare',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'estimate_no'=>'Estimate No',
            'category'=>'Category',
            'dept'=>'Department',
            'category'=>'Category',
            'version' =>'Version',
            'estimate_no_helper'=>'',
            'estimate_total'=>'Estimate Total',
            'estimate_total_helper'=>'',
            'item_number'=>'Item Number(Ver.)',
            'sor'=>'SOR Number',
            'other' => 'Other',
            'per_unit_cost' =>'Per Unit Cost',
            'item_name'=>'Item Name',
            'operation'=>'Operations',
            'total_on_selected'=>'Total On Selected',
            'export_word'=>'Export Word',
            'description'=>'Description',
            'quantity'=>'Quantity',
            'unit_price'=>'Unit Price(RS.)',
            'remarks' =>'Remarks',
            'status'=>'Status',
            'cost'=>'Cost(RS.)',
            'action'=>'Actions',
            'No_listMsg'=> 'No Items Added Yet !'
        ],
    ],
    'estimate_recommender'=>[
        'title'=>'Estimate recommender',
        'title_singular'=>'Estimate recommenders',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'estimate_no'=>'Estimate No(Project ID)',
            'estimate_total'=>'Estimate Cost',
            'estimate_recommender_cost'=>'Estimate Recommender Cost',
            'item_number'=>'Item Number(Ver.)',
            'description'=>'Description',
            'quantity'=>'Quantity',
            'unit_price'=>'Unit Price',
            'status'=>'Status',
            'cost'=>'Cost',
            'action'=>'Actions'
        ],
    ],
    'estimate_project'=>[
        'title'=>'Estimate Project',
        'title_singular'=>'Estimate Projects',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'description'=>'Description',
            'estimate_no'=>'Estimate No',
            'estimate_total'=>'Estimate Total',
            'project_no'=>'Project No',
            'item_number'=>'Item Number(Ver.)',
            'quantity'=>'Quantity',
            'unit'=>'Unit',
            'unit_price'=>'Unit Price(Rs.)',
            'cost'=>'Cost(Rs.)',
            'status'=>'Status',
            'action'=>'Actions'
        ],
        'labels'=>[
            'category'=>'Category',
            'select_version'=>'Select Version',
            'search_sor_number'=>'Search SOR Number',
            'quantity'=>'Quantity',
            'unit_cost'=>'Per Unit Cost',
            'cost'=>'Cost',
            'item_name'=>'Item Name',
            'added_estimate_list'=>'Added Estimates List',
            'operations'=>'Operations',
            'total_on_selected'=>'Total On Selected',
            'export_word'=>'Export Word'
        ],
    ],
    'menu-permission'=>[
        'title'=>'Menu Permission',
        'title_singular'=>'Menu Permissions',
        'fields'=>[
            'Id'=>'ID',
            'id_helper'=>'#',
            'user_type'=>'User Type',
            'menu_access'=>'Menu Access',
            'actions'=>'Actions',
        ],
    ],
    'milestone'=>[
        'title'=>'MileStone',
        'title_singular'=>'Milestones',
        'create_msg'=>'New Milestone Created',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'project_num'=>'Project Number',
            'desc'=>'Project Description',
            'm_name'=>'Milestone name',
            'm_parent_id'=>'parent Milestone name',
            'param'=>'Param'
        ],
    ],
    'vendors'=>[
        'title'=>'Vendor Informations',
        'title_singular'=>'Vendors Informations',
        'menu_title'=>'Vendors Information',
        'create_msg'=>'Vendor created!',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'comp_name'=>'Company Name',
            'tin'=>'TAN Number',
            'pan'=>'PAN Number',
            'gstin'=>'GSTIN No.',
            'mobile'=>'Mobile',
            'address'=>'Address',
            'class_vendor'=>'Class of Vendor',
            'v_type'=>'Vendor Type',
            'action'=>'actions'
        ],
    ],
    'aafs_project'=>[
        'title'=>'AAFS Project Details',
        'title_singular'=>'AAFS Projects',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'proj_id'=>'Project No',
            'Govt_id'=>'GO No.',
            'go_date'=>'GO Date',
            'file_upload'=>'project file',
            'file_note'=>'project related file upload here ,file extension must be pdf,jpg,jpeg',
            'action'=>'actions'
        ],
    ],
    'settings'=>[
        'title'=>'Settings',
        'title_singular'=>'Settings',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'slug'=>'Slug',
            'unit_type'=>'Unit Type',
            'sor_category'=>'SOR Category',
            'estimate_status'=>'Estimate Status',
            'active'=>'Status',
            'actions'=>'Action',
        ],
    ],
    'permissions'=>[
        'title'=>'Permissions',
        'title_singular'=>'Permission',
        'create_mgs'=>'New permission created!',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'permission_name'=>'Permission Name',
            'actions'=>'Action',
        ],
    ],
    'roles'=>[
        'title'=>'Role',
        'title_singular'=>'Roles',
        'create_msg'=>'Role created!',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'role_name'=>'Role Name',
            'actions'=>'Actions',
        ],
    ],
    'tenders'=>[
        // 'title'=>'Award of Contacts',
        'title'=>'Tender Information',
        'title_singular'=>'Award of Contract',
        'create_msg'=>'created success',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'project_id'=>'Project No.',
            'tender_id'=>'Tender No.',
            'tender_title'=>'Tender Title',
            'date_of_pub'=>'Date Of Published',
            'date_of_close'=>'Date Of Closing',
            'num_bider'=>'Number Of Biders',

            'title'=>'Tender Title',
            'ref_no'=>'Reference No.',
            'category'=>'Tender Category',
            'actions'=>'Action',
        ],
    ],
    'aocs'=>[
        // 'title'=>'IFMS Fund',
        'title'=>'Awards of Contracts',
        'title_singular'=>'IFMS funds release',
        'create_msg'=>'Fund created',
        'fields'=>[
            'id'=>'ID',
            'id_helper'=>'#',
            'project_id'=>'Project No',
            'go_id'=>'Go Number',
            'vendor_id'=>'Vendor',
            'go_order'=>'Go Order',
            'amount'=>'Amount',
            'approved_date'=>'Approved Date',
            'support_data'=>'Supported data',
            'status'=>'Status',
            'actions'=>'Actions'
        ],
    ],
];
