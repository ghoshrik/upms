<x-modal.card title="Maker List" blur wire:model="showModal" data-backdrop="static">
    <div class="overflow-x-auto mt-4 p-2">
        <table class="min-w-full border border-gray-200 rounded-lg w-full">
            <thead class="bg-gray-100">
                <tr>
                    {{-- <th class="px-4 py-2 text-left text-gray-700 font-medium">Office</th> --}}
                    <th class="px-4 py-2 text-left text-gray-700 font-medium">User</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-medium">Email</th>

                    {{-- <th class="px-4 py-2 text-left text-gray-700 font-medium">Assigned At</th> --}}
                    {{-- <th class="px-4 py-2 text-left text-gray-700 font-medium">Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                {{-- @dd($userLists); --}}
                <tr>
                    
                    {{-- <td>{{$userLists->getOfficeName->office_name}}</td> --}}
                    <td>{{$userLists->emp_name ??''}}</td>
                    <td>{{$userLists->email ??''}}</td>
                    {{-- <td>{{$userLists->getDesignationName->designation_name ??''}}</td> --}}
                    {{-- <td>{{$projectDetials->assigned_at ??''}}</td>s --}}
                </tr>
            </tbody>
        </table>
    </div>
</x-modal.card>