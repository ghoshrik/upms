
@foreach($lists->children as $child)
<li>
    <div class="treeview__level" data-level="C">
        <span class="level-title">{{ $child->parent_id }}</span>
        <div class="treeview__level-btns">
            <div class="btn btn-default btn-sm level-add"><span class="fa fa-plus"></span></div>
            <div class="btn btn-default btn-sm level-remove"><span class="fa fa-trash text-danger"></span></div>
        </div>
    </div>
</li>
@endforeach
