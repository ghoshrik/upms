<div>
    {{-- TODO::Add remarks to database --}}
     @if (Auth::user()->user_type == 6)
     {{ cache($value.'|recomender') }}
     @else
     {{ cache($value.'|forwader') }}
     @endif
</div>
