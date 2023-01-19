@foreach ($stone->children as $lists)
    <li>
        <div class="treeview__level" data-level="B">
            <span class="level-title">{{ $lists->parent_id }}</span>
            <div class="treeview__level-btns">
                <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
                <div class="btn btn-default btn-sm level-remove"><span class="fa fa-trash text-danger"></span></div>

            </div>
        </div>
        <ul>
            @if(count($lists->children)>0)
                @include('child')
            @endif
        </ul>
    </li>
@endforeach
