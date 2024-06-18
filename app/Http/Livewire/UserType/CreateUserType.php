<?php

namespace App\Http\Livewire\UserType;

use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class CreateUserType extends Component
{
    use Actions;
    public $dropdownData = [], $formData = [];
    public function mount()
    {
        $this->formData['user_type'] = '';
        $this->formData['user_type_id'] = '';
        $authUserType = Auth::user()->user_type;
        $parentTypeId = UserType::find($authUserType)->parent_id;
        $this->dropdownData['user_types_list'] = UserType::where('id', '!=', $parentTypeId)
        // ->where('id', '!=', $authUserType)
            ->get();
    }
    public function store()
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Prepare the data to insert
            $insert = [
                'type' => trim($this->formData['user_type']),
                'parent_id' => $this->formData['user_type_id'],
            ];
            // Attempt to create a new UserType
            $newUserType = UserType::create($insert);
            // And Create Same Role also
            $createdRole = Role::create(['name' => trim($this->formData['user_type'])]);
            // If the creation is successful
            if ($newUserType && $createdRole) {
                $defaultPermissions = [1, 8, 10, 12];
                foreach ($defaultPermissions as $permissionId) {
                    DB::table('role_has_permissions')->insert([
                        'role_id' => $createdRole->id,
                        'permission_id' => $permissionId,
                    ]);
                }
                // Commit the transaction
                DB::commit();
                // Display a success notification
                $this->notification()->success(
                    $title = 'Success',
                    $description = 'User Type and Role is Created. Add the permissions from Roles menu.'
                );

                // Emit an event to open the entry form
                $this->emit('openEntryForm');
                // Reset the form
                $this->reset();
            }

        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Optionally log the error or handle it as needed
            // Log::error('Error creating user type: ' . $e->getMessage());

            // Display an error notification
            $this->notification()->error(
                $title = 'Error',
                $description = $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.user-type.create-user-type');
    }
}
