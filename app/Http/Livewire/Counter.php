<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class Counter extends Component
{
    use Actions;
    public $simpleModal =true;
    public function render()
    {
        return view('livewire.counter');
    }
    public function alert(): void
    {
        // use a simple syntax: success | error | warning | info
        // $this->notification()->success(
        //     $title = 'Profile saved',
        //     $description = 'Your profile was successfull saved'
        // );
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Save the information?',
            'icon'        => 'success',
            'accept'      => [
                'label'  => 'Yes, save it',
                'method' => 'save',
                'params' => 'Saved',
            ],
            'reject' => [
                'label'  => 'No, cancel',
                'method' => 'cancel',
            ],
        ]);
    }
}
