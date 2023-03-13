<?php

namespace App\Http\Livewire\Admin\Auth;

use App\Repositories\Auth\LoginRepository;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $response;
    public $err  = false;

    public $easylogin = 'orang@awam.com';

    protected $rules =  [
        'email' => 'required',
        'password' => 'required'
    ];

    public function signin()
    {
        $this->validate();

        $data = [
            'email' => $this->email,
            'password' => $this->password
        ];

        $signin = new LoginRepository();

        $login = $signin->signin($data);

        if($login['status'] == 200)
        {
            return redirect()->route('control');
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
            return redirect()->route('control');
        }

    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
