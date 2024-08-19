<div>
    {{-- <div class="py-0 mt-3 container-fluid content-inner"> --}}
        {{-- <div style="height: 65px;">
            <div class="container-fluid iq-container">
                <div class="d-flex flex-column">
                    <h3 class="text-dark  mt-3">MIS REPORT FOR USERS</h3>
                </div>
            </div>
        </div>
        @section('webtitle', trans('cruds.office.title')) --}}
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="container my-5">
                                    <table class="table text-center table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>SlNo</th>
                                                <th>Department</th>
                                                <th>Groups</th>
                                                <th>Offices</th>
                                                <th>Users</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($departmentSummaryArray as $index => $department)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $department['department_name'] }}</td>
                                                <td>{{ $department['group_count'] }}</td>
                                                <td>{{ $department['office_count'] }}</td>
                                                <td>{{ $department['user_count'] }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" type="button"
                                                        id="toggleButton{{ $index }}" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                                                        aria-controls="collapse{{ $index }}">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" />
                                                        <span class="btn-text">View</span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="collapse" id="collapse{{ $index }}">
                                                        <div class="card card-body">
                                                            <div class="mt-4 table-responsive">
                                                                <table class="table mb-0 table-striped table-bordered"
                                                                    role="grid">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">SlNo</th>
                                                                            <th scope="col">Group list</th>
                                                                            <th scope="col">Offices</th>
                                                                            <th scope="col">Users</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php $groupIndexx =1; @endphp
                                                                        @foreach ($groupDetailArray as $groupIndex =>
                                                                        $groupDetail)
                                                                        @if ($groupDetail['department_name'] ==
                                                                        $department['department_name'])
                                                                        <tr>
                                                                            <td>{{ $groupIndexx++ }}</td>
                                                                            <td>{{ $groupDetail['group_name'] }}</td>
                                                                            <td>{{ $groupDetail['total_office_count'] }}
                                                                            </td>
                                                                            <td>{{ $groupDetail['total_user_count'] }}
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            const collapseElement = document.querySelector(button.getAttribute('data-bs-target'));
            const textElement = button.querySelector('.btn-text');
            button.addEventListener('click', function () {
                const isExpanded = collapseElement.classList.contains('show');
                textElement.textContent = isExpanded ? 'View' : 'Hide';
            });
            collapseElement.addEventListener('shown.bs.collapse', function () {
                textElement.textContent = 'Hide';
            });
            collapseElement.addEventListener('hidden.bs.collapse', function () {
                textElement.textContent = 'View';
            });
        });
    });
</script>
