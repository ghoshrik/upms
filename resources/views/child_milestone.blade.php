<li>
    <div class="treeview__level" data-level="S">
        <span class="level-title">{{ $child_milestone->milestone_name }}</span>
        <div class="treeview__level-btns">
            @if($child_milestone->Is_achived=='verified')
                {{$child_milestone->Is_achived}}
            @else
                <div class="btn btn-default btn-sm level-add">{{$child_milestone->created_at->format('Y-m-d')}}</div>
                <input type="file" class="btn-sm level-add" placeholder="file..." />
                <div class="btn btn-default btn-sm level-add" wire:click='ApprovedMilestone({{$child_milestone->milestone_name}})'>{{$child_milestone->Is_achived}}</div>

            @endif
        </div>
    </div>
    @if (count($child_milestone->milestones)>0)
        <ul>
            @foreach ($child_milestone->milestones as $childMilestone)
            @include('child_milestone',['child_milestone'=>$childMilestone])
            @endforeach
        </ul>
    @endif
</li>
