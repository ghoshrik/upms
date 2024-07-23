@php
    $checkForDraft = App\Models\SORMaster::where('estimate_id', $value)->first();
    $user = Auth::user()->roles->first();
    $level = 0;
@endphp
@include('components.data-table-components.buttons.view')
@if ($checkForDraft['status'] != 2 || $checkForDraft['status'] != 8)


    @if ($user->has_level_no != 6)
        @php
            // $roleParent = Auth::user()->roles1->first();
            $estimateTotal = App\Models\EstimatePrepare::select('total_amount')
                ->join('estimate_masters', 'estimate_prepares.estimate_id', '=', 'estimate_masters.estimate_id')
                ->where('estimate_masters.estimate_id', $value)
                ->where('estimate_masters.dept_id', Auth::user()->department_id)
                ->where('estimate_prepares.operation', 'Total')
                ->first();

            $estimateLimits = App\Models\EstimateAcceptanceLimitMaster::where(
                'department_id',
                Auth::user()->department_id,
            )->get();
            // Default to 'error' if no matching limit is found
            // @dd($estimateTotal, $estimateTotal['total_amount']);
            foreach ($estimateLimits as $estimateAmount) {
                // @dd($estimateTotal['total_amount'], $estimateAmount['min_amount'])
                if ($estimateTotal['total_amount'] > $estimateAmount['min_amount'] && $estimateTotal['total_amount'] <= $estimateAmount['max_amount']) {
                    $level = $estimateAmount['level_id'];
                    break; // Exit the loop once a matching limit is found
                }
                $level = $estimateAmount['level_id'];
            }
            // $roleLevelNo = App\Models\Role::select('name', 'has_level_no')->where('id', $roleParent->has_level_no)->first();
            // @dd($roleParent, 'has level No', $roleParent->has_level_no, $estimateTotal, $level);
        @endphp
    @endif
    @if ($user->has_level_no == $level - 1)
    @include('components.data-table-components.buttons.approve')
    @else
        @include('components.data-table-components.buttons.forward')
    @endif

@endif
@if (Auth::user()->can('modify estimate'))
    @include('components.data-table-components.buttons.modify')
@else
    @include('components.data-table-components.buttons.edit')
@endif
@if (Auth::user()->can('revert estimate'))
    @include('components.data-table-components.buttons.revert')
@endif
