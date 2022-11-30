@props(['submit'])
<div class="col-sm-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="{{ $submit }}">
                {{$form}}
            </form>
        </div>
    </div>
</div>
