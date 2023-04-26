<div class="col-lg-12 bg-primary">
        <div class="col-lg-12 text-capitalize text-white" style="text-align: right; overflow:hidden; padding-right:2%">
            @if (Auth::user()->department_id)
              {{ getDepartmentName(Auth::user()->department_id) }}
            @endif
            @if (Auth::user()->designation_id)
                / {{ getDesignationName(Auth::user()->designation_id) }}
            @endif
        </div>
</div>
