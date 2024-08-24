<div class="col-lg-12 col-sm-6 col-md-6">
    <div class="col-lg-12 text-capitalize text-white"
        style="background: #7f8fdc;text-align: right; overflow:hidden; padding-right:2%;margin-top: 70px;overflow-y: auto;position: sticky;">
        @if (Auth::user()->department_id)
{{--            {{ getDepartmentName(Auth::user()->department_id) }}--}}
            {{Auth::user()->getDepartmentName?->department_name??''}}
        @endif
        @if (Auth::user()->designation_id)
{{--            / {{ getDesignationName(Auth::user()->designation_id) }}--}}
            / {{Auth::user()->getDesignationName?->designation_name??''}}
        @endif
    </div>
</div>
