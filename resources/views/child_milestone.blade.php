<li>
    <div class="treeview__level" data-level="S">
        <span class="level-title">{{ $child_milestone->milestone_name }}</span>
        <div class="treeview__level-btns">
            <div class="btn btn-default btn-sm level-add">{{$milestone->created_at->format('Y-m-d')}}</div>
            <input type="file" class="btn-sm level-add" placeholder="  file..." />
            <div class="btn btn-default btn-sm level-add">status</div>
        </div>
    </div>
    @if ($child_milestone->milestones)
    <ul>
        @foreach ($child_milestone->milestones as $childMilestone)
        @include('child_milestone',['child_milestone'=>$childMilestone])
        @endforeach
    </ul>
    @endif
</li>
