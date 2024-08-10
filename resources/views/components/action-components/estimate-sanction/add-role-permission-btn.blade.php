@php
    $sanction_roles = App\Models\SanctionLimitMaster::where('id', $id)->first();
    $section_roles_count = $sanction_roles
        ->roles()
        ->with(['role', 'permission'])
        ->count();
@endphp
<button wire:click="add({{ $id }})" type="button" class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded">
    @if ($section_roles_count > 0)
        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
            {{ $section_roles_count }}
            <span class="visually-hidden">unread messages</span>
        </span>
    @else
        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Add
    @endif
</button>
