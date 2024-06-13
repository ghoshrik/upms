<?php

namespace App\Http\Livewire\UserType;

use Livewire\Component;
use App\Models\UserType;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Auth;

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
                'type' => $this->formData['user_type'],
                'parent_id' => $this->formData['user_type_id'],
            ];

            // Attempt to create a new UserType
            $newUserType = UserType::create($insert);

            // If the creation is successful
            if ($newUserType) {
                // Commit the transaction
                DB::commit();

                // Display a success notification
                $this->notification()->success(
                    $title = 'Success',
                    $description = trans('cruds.user-management.create_msg')
                );

                // Reset the form
                $this->reset();

                // Emit an event to open the entry form
                $this->emit('openEntryForm');
            }

        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Optionally log the error or handle it as needed
            Log::error('Error creating user type: ' . $e->getMessage());

            // Display an error notification
            $this->notification()->error(
                $title = 'Error',
                $description = 'There was an error creating the user type. Please try again.'
            );
        }
    }

    public function render()
    {
        return view('livewire.user-type.create-user-type');
    }
}
