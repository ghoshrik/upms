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
    public $subTitle, $title, $formData = [],$errorMessage;


    protected $rules = [
        'formData.cur_password' => 'required',
        'formData.pwd' => 'required|min:8|different:formData.cur_password',
        'formData.conf_pwd' => 'required|same:formData.pwd',
    ];
    protected $messages = [
        'formData.cur_password.required' => 'This field is must be required',
        'formData.conf_pwd.required' => 'This field is must be required',
        'formData.pwd.required' => 'This field is must be required',
        'formData.pwd.min' => 'The New Password must be at least 8 characters',
//        'formData.pwd.confirmed'=>'The new password confirmation does not match.',
        'formData.pwd.different'=>'The new password cannot be the same as the current password.',
        'formData.conf_pwd.same'=>'The new password and confirm password does not match.'
    ];

    public function mount()
    {
        $this->formData['pwd'] = '';
        $this->formData['cur_password'] = '';
        $this->formData['conf_pwd'] = '';
        $this->formData['email'] = '';
        $this->formData['mobile'] = '';

        $userDtls = User::where('id', Auth::user()->id)->first();
        $this->formData['email'] = $userDtls->email;
        $this->formData['mobile'] = $userDtls->mobile;
    }
//    public function updatedFormDataCurPassword($value)
//    {
//        dd('test data');
//        $this->validateOnly('formData.cur_password');
//    }
    public function updatedFormDataPwd($value)
    {
        $this->validateOnly('formData.pwd');
    }
    public function updatePassword(Request $request)
    {
        $this->validate();

        // Check if current password matches
        if (!Hash::check($this->formData['cur_password'], Auth::user()->password)) {
            $this->notification()->error(
                $title = 'Current password does not match',
            );
            return;
        }

        User::where('id', Auth::user()->id)->update(['password' => Hash::make($this->formData['pwd'])]);

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate(true);

        $this->notification()->success(
            $title = 'User Password updated',
        );
        $this->reset();
        $this->emit('passwordUpdated');

    }
    public function updateProfile()
    {

        User::where('id', Auth::user()->id)->update(['mobile' => $this->formData['mobile']]);
        $this->notification()->success(
            $title = 'User Profile update',
        );
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        return view('livewire.profile.auth-password');
    }
}
