<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Repositories\Auth\LoginRepository;

class Signin extends Component
{
    public $username;
    public $password;
    public $response;
    public $err  = false;

    public $easylogin = 'orang@awam.com';

    protected $rules =  [
        'username' => 'required',
        'password' => 'required'
    ];

    public function signin()
    {
        $this->validate();

        $data = [
            'username' => $this->username,
            'password' => $this->password
        ];

        $signin = new LoginRepository();

        $login = $signin->signin($data);

        if($login['status'] == 200)
        {
            return redirect()->route('dashboard');
        }else{
            $this->err = true;
            $this->response = $login['message'];
        }
    }

    public function clickLogin()
    {
        //for staging only

        $data = [
            'username' => $this->easylogin
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
        return view('livewire.auth.signin');
    }
}
