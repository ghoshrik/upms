<div class="col-lg-12" style="background: #7f8fdc">
        <div class="col-lg-12 text-capitalize text-white" style="text-align: right; overflow:hidden; padding-right:2%">
            @if (Auth::user()->department_id)
              {{-- {{ getDepartmentName(Auth::user()->department_id) }} --}}
              {{ Auth::user()->getDepartmentName->department_name }}
            @endif
            @if (Auth::user()->designation_id)
                / {{Auth::user()->getDesignationName->designation_name}}
            @endif
        </div>
</div>
