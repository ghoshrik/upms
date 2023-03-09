@props(['title'])
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
            </div>
            <div class="card-body p-3">
                {{ $table }}
            </div>
        </div>
    </div>
</div>

