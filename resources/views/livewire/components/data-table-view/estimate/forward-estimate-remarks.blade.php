 @php
    //  $getParentId = App\Models\User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
    //      ->join('access_types', 'access_types.id', '=', 'access_masters.access_type_id')
    //      ->where('access_masters.user_id', $value)
    //      ->first();
     $getRemarks = App\Models\EstimateUserAssignRecord::where('estimate_user_id', Auth::user()->id)->where('estimate_user_type',1)->orWhere('estimate_user_type',2)->where('estimate_id',$value)->first();
    //  print_r('<pre>');
    //  print_r($getRemarks);
    //  print_r('</pre>');
    //  $get= App\Models\SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
    //     ->where('estimate_user_assign_records.estimate_user_type','=',3)
    //     ->where('sor_masters.status',2)
    // //     ->where('estimate_user_assign_records.estimate_user_id',Auth::user()->id)->get();
    // print_r('<pre>');
    //  print_r($getRemarks);
    //  print_r('</pre>');
 @endphp
 {{-- {{ $getRemarks['comments'] }} --}}
 {{ $getRemarks['comments'] }}
