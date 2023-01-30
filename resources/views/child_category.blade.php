<li>
    <div class="treeview__level" data-level="B">
        <span class="level-title">{{ $child_category->name }}</span>
        <div class="treeview__level-btns">
            <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
            <div class="btn btn-default btn-sm level-remove"><span class="fa fa-trash text-danger"></span></div>
            <div class="btn btn-default btn-sm level-same"><span>Add Same Level</span></div>
            <div class="btn btn-default btn-sm level-sub"><span>Add Sub Level</span></div>
        </div>
    </div>
    @if ($child_category->categories)
    <ul>
        @foreach ($child_category->categories as $childCategory)
            @include('child_category',['child_category'=>$childCategory])
        @endforeach
    </ul>
    @endif
</li>
