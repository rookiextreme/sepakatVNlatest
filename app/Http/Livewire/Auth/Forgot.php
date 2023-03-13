<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Repositories\Auth\ForgotRepository;
use Illuminate\Support\Facades\Log;

class Forgot extends Component
{
    public $lang = 'bm';
    public $email;

    public $err = false;
    public $response = "";

    protected $rules =  [];
    protected $messages = [];

    public function send()
    {

        if(session()->get('sess_lang')){
            $this->lang = session()->get('sess_lang');
        }

        $langEmail = [
            'bm' => 'Sila masukkan emel anda',
            'en' => 'Please enter your email'
        ];

        $this->rules = [
            'email' => 'required'
        ];

        $this->messages = [
            'email.required' => $langEmail[$this->lang]
        ];

        $this->validate();


        $data = [
            'email' => $this->email
        ];

        $requestForgot = new ForgotRepository();

        $forgot = $requestForgot->requestEmailForgotPassword($data);

        if($forgot['status'] == 200)
        {
            session()->put('sess_req_email', $this->email);
            return redirect()->route('forgot.request.success', [
                'email' => $this->email
            ]);

        }else{

            Log::info('masuk sini klo xjumpa');
            Log::info($forgot);
            $this->err = true;
            $this->response = $forgot['message'];
        }

    }



    public function render()
    {
        Log:info("hello here 2");
        return view('livewire.auth.forgot');
    }
}

