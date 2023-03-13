<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Repositories\Auth\LoginRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Login extends Component
{
    public $username;
    public $password;
    public $response;
    public $err  = false;

    public $easylogin = 'orang@awam.com';

    protected $rules =  [];
    protected $messages = [];

    public function signin()
    {
        $this-> rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $this-> messages = [
            'username.required' => 'Sila masukkan ID Pengguna anda',
            'password.required' => 'Sila masukkan kata laluan anda'
        ];

        $this->validate();

        $data = [
            'username' => $this->username,
            'password' => $this->password
        ];

        $signin = new LoginRepository();

        $login = $signin->signin($data);

        if($login['status'] == 200)
        {
            if (Auth::user()->roleAccess()->code == '01') {
                return redirect()->route('access.admin');
            } else if(Auth::user()->roleAccess()->code == '02'){
                return redirect()->route('access.management');
            } else if(Auth::user()->roleAccess()->code == '03'){
                return redirect()->route('access.operation');
            } else {
                return redirect()->route('access.public');
            }
        }else{
            $this->err = true;
            $this->response = $login['message'];
        }
    }

    public function clickLogin()
    {
        //for staging only

        $data = [
            'email' => $this->easylogin
        ];

        $signin = new LoginRepository();

        $login = $signin->easyLogin($data);

        if($login['status'] == 200)
        {
            return redirect()->route('dashboard');
        }

    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
