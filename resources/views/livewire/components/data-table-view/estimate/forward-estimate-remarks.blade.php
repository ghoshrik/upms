 @php
     $getParentId = App\Models\User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
         ->join('access_types', 'access_types.id', '=', 'access_masters.access_type_id')
         ->where('access_masters.user_id', $value)
         ->first();
     $getRemarks = App\Models\EstimateUserAssignRecord::where('estimate_user_type', '=', $getParentId['access_parent_id'])->first();
     print_r('<pre>');
     print_r($getRemarks);
     print_r('</pre>');
 @endphp
 {{ $getRemarks['comments'] }}
