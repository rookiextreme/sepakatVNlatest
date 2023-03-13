<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationDAO extends Controller
{
    public $lang = 'bm';
    public $lblRegister;
    public $lblLogin;
    public $lblSsoLogin;
    public $lblDashboard;
    public $lblUsername;
    public $lblPassword;
    public $lblBtnLogin;
    public $lblBtnReset;
    public $lblBtnNewUser;
    public $lblBtnForgotPass;
    public $lblTerms;
    public $lblCondition;
    public $lblForgotPassword;
    public $lblEmail;
    public $lblSend;
    public $lblForgotUsername;
    public $lblRequestFP;
    public $lblRequestFPLinkMsg;
    public $lblRequestFU;
    public $lblRequestFUMsg;
    public $lblRequestRS;
    public $lblRequestRSMsg;

    public function mount(){

        $this->language();

    }

    public function language(){

        if(Request('lang')){
            session()->put('sess_lang', Request('lang'));
        }

        if(session()->get('sess_lang')){
            $this->lang = session()->get('sess_lang');
        }

        $langRegister = [
            'bm' => 'Daftar',
            'en' => 'Register'
        ];
        $this->lblRegister = $langRegister[$this->lang];

        $langLogin = [
            'bm' => 'Log Masuk',
            'en' => 'Log in'
        ];
        $this->lblLogin = $langLogin[$this->lang];

        $langSsoLogin = [
            'bm' => 'Log Masuk SSO',
            'en' => 'SSO Log in'
        ];
        $this->lblSsoLogin = $langSsoLogin[$this->lang];

        $langDashboard = [
            'bm' => 'Halaman Utama',
            'en' => 'Dashboard'
        ];
        $this->lblDashboard = $langDashboard[$this->lang];

        $langUsername = [
            'bm' => 'ID Pengguna',
            'en' => 'Username'
        ];
        $this->lblUsername = $langUsername[$this->lang];

        $langPassword = [
            'bm' => 'Kata Laluan',
            'en' => 'Password'
        ];
        $this->lblPassword = $langPassword[$this->lang];

        $langBtnLogin = [
            'bm' => 'Masuk',
            'en' => 'Enter'
        ];
        $this->lblBtnLogin = $langBtnLogin[$this->lang];

        $langBtnReset = [
            'bm' => 'Set Semula',
            'en' => 'Reset'
        ];
        $this->lblBtnReset = $langBtnReset[$this->lang];

        $langBtnNewUser = [
            'bm' => 'Pengguna Baharu',
            'en' => 'Register'
        ];
        $this->lblBtnNewUser = $langBtnNewUser[$this->lang];

        $langBtnForgotPass = [
            'bm' => 'Lupa Kata Laluan',
            'en' => 'Forgot Password'
        ];
        $this->lblBtnForgotPass = $langBtnForgotPass[$this->lang];

        $langTerms = [
            'bm' => 'Terma',
            'en' => 'Terms'
        ];
        $this->lblTerms = $langTerms[$this->lang];

        $langCondition = [
            'bm' => 'Syarat',
            'en' => 'Condition'
        ];
        $this->lblCondition = $langCondition[$this->lang];

        $langForgotPassword = [
            'bm' => 'Lupa Kata Laluan',
            'en' => 'Forgot Password'
        ];
        $this->lblForgotPassword = $langForgotPassword[$this->lang];

        $langEmail = [
            'bm' => 'Emel',
            'en' => 'Email'
        ];
        $this->lblEmail = $langEmail[$this->lang];

        $langSend = [
            'bm' => 'Hantar',
            'en' => 'Send'
        ];
        $this->lblSend = $langSend[$this->lang];

        $langForgotUsername = [
            'bm' => 'Lupa ID Pengguna',
            'en' => 'Forgot Username'
        ];
        $this->lblForgotUsername = $langForgotUsername[$this->lang];

        $langOtherOptions = [
            'bm' => 'Opsyen Lain',
            'en' => 'Other Options'
        ];
        $this->lblOtherOptions = $langOtherOptions[$this->lang];

        $langRequestFP = [
            'bm' => 'Permintaan berjaya',
            'en' => 'Request sent Successfully'
        ];
        $this->lblRequestFP = $langRequestFP[$this->lang];

        $langRequestFPLinkMsg = [
            'bm' => 'Pautan untuk menukar kata laluan telah dihantar ke Emel ',
            'en' => 'Link has been sent to email ',
        ];
        $this->lblRequestFPLinkMsg = $langRequestFPLinkMsg[$this->lang];

        $langRequestFU = [
            'bm' => 'Permintaan berjaya',
            'en' => 'Request sent Successfully'
        ];
        $this->lblRequestFU = $langRequestFU[$this->lang];

        $langRequestFUMsg = [
            'bm' => 'ID Pengguna telah dihantar ke Emel ',
            'en' => 'Username has been sent to email ',
        ];
        $this->lblRequestFUMsg = $langRequestFUMsg[$this->lang];

        $langRequestRS = [
            'bm' => 'Permintaan berjaya',
            'en' => 'Request sent Successfully'
        ];
        $this->lblRequestRS = $langRequestRS[$this->lang];

        $langRequestRSMsg = [
            'bm' => 'Notifikasi akan dihantar ke email berdaftar selepas proses verifikasi selesai. ',
            'en' => 'Notification will be send after process verification has been completed. ',
        ];
        $this->lblRequestRSMsg = $langRequestRSMsg[$this->lang];

    }

}
