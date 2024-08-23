<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthPassword extends Component
{
    use Actions;
    public $subTitle, $title, $formData = [];
    protected $listeners = ['changePassword'];


    protected $rules = [
        'formData.cur_password' => 'required',
        'formData.conf_pwd' => 'required',
        'formData.pwd' => 'required|min:8',
    ];
    protected $messages = [
        'formData.cur_password.required' => 'This field is must be required',
        'formData.conf_pwd.required' => 'This field is must be required',
        'formData.pwd.required' => 'This field is must be required',
        'formData.pwd.min:8' => 'New Password must be at least 8 characters',
    ];

    public function mount()
    {
        $this->notification()->success(
            $title = 'User Password updated',
        );
        $this->formData['pwd'] = '';
        $this->formData['cur_password'] = '';
        $this->formData['conf_pwd'] = '';
        $this->formData['email'] = '';
        $this->formData['mobile'] = '';

        $userDtls = User::where('id', Auth::user()->id)->first();
        $this->formData['email'] = $userDtls->email;
        $this->formData['mobile'] = $userDtls->mobile;
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function updatePassword()
    {
        $this->validate();

        // Check if current password matches
        if (!Hash::check($this->formData['cur_password'], Auth::user()->password)) {
            $this->notification()->error(
                $title = 'Current password does not match',
            );
        }

        User::where('id', Auth::user()->id)->update(['password' => Hash::make($this->formData['pwd'])]);

        Auth::guard('web')->logout();


        $this->notification()->success(
            $title = 'User Password updated',
        );
        $this->reset();
    }
    public function updateProfile()
    {

        User::where('id', Auth::user()->id)->update(['email' => $this->formData['email'], 'mobile' => $this->formData['mobile']]);
        $this->notification()->success(
            $title = 'User Profile updated',
        );
        $this->reset();
    }
    public function render()
    {
        $this->notification()->success(
            $title = 'User Password updated',
        );
        return view('livewire.profile.auth-password');
    }
}
