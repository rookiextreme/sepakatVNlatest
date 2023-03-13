<?php

namespace App\Repositories\Auth;

use App\Http\Livewire\Admin\Auth\Login;
use App\Mail\ForgotAccount;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Models\Users\UserVerification;
use Carbon\Carbon;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotRepository

{
    public $lang = 'bm';

    public function checkExistAccountAndSend($data){

        if(session()->get('sess_lang')){
            $this->lang = session()->get('sess_lang');
        }

        $langEmailResVerify = [
            'bm' => 'Emel belum diverifikasi',
            'en' => 'Email under verification'
        ];

        $langEmailResNotExisted = [
            'bm' => 'Emel tidak wujud',
            'en' => 'Email does not existed'
        ];

        Log::info('masuk /checkExistAccountAndSend');

        $user = User::where('email', $data['email'])->first();

        if($user && $user->detail &&  $user->detail->refStatus->code == '03'){
            $response = [
                'status' => 400,
                'message' => $langEmailResVerify[$this->lang]
            ];
        } else if($user && $user->detail && $user->detail->refStatus->code != '03')
        {
            Log::info('ada data ...');
            Log::info($user);

            $data = [
                'title' => 'Lupa ID Pengguna',
                'subject' => 'Lupa ID Pengguna',
                'user-name' => $user->name,
                'username' => $user->username,
                'lang' => $this->lang,
            ];
            Mail::to($user)->send(new ForgotAccount($data));

            //function hantar email
            $response = [
                'status' => 200,
                'message' => ''
            ];
            
        } else {

            $response = [
                'status' => 400,
                'message' => $langEmailResNotExisted[$this->lang]
            ];
        }

        return $response;
    }
    public function requestEmailForgotPassword($data)
    {
        if(session()->get('sess_lang')){
            $this->lang = session()->get('sess_lang');
        }

        $langEmailResNotExisted = [
            'bm' => 'Emel tidak wujud',
            'en' => 'Email does not existed'
        ];

        $user = User::where('email', $data['email'])->first();
        Log::info($user);

        $email = $data['email'];

        Log:info("hello :".$email);

        if(empty($user)){
            return [
                'status' => 400,
                'message' => $langEmailResNotExisted[$this->lang]
            ];
        }

        if(!empty($email) && $user->email)
        {

            $token = sha1(uniqid(time(), true));
            $url = route('activation.user', [
                "token" => $token,
                "view" => 'forgot_password'
            ]);

            $data = [
                'subject' => 'Lupa Katalaluan '.Carbon::now()->format('d/m/Y'),
                'title'=> '',
                'body' => '',
                'user-name' => $user->name,
                'url' => $url,
                'lang' => $this->lang,
            ];

            $delPrev = UserVerification::where([
                'user_id' =>  $user->id
            ]);

            $delPrev->delete();

            UserVerification::create([
                'user_id'=> $user->id,
                'token' => $token,
                'status' => true,
                'expired_token' => Carbon::now()->addDays(3)
            ]);

            // $mail_to_users = ["farid.developer.1992@gmail.com", "farid.develop121212r.1asdsadsad992@g121212mail.com"];
            // $failures = [];

            // foreach($mail_to_users as $mail_to_user) {
            // Mail::send('emails.email', [], function($msg) use ($mail_to_user){
            //     Log::info($mail_to_user);

            //     $validator = new EmailValidator();
            //     $isvalid = $validator->isValid($mail_to_user, new RFCValidation()); //true

            //     Log::info('isvalid => '.$isvalid);
                
            //     $msg->to($mail_to_user);
            //     $msg->subject("Document Shared");
            // });

            // if( count( Mail::failures() ) > 0 ) {
            //     $failures[] = Mail::failures()[0];
            // }
            // }

            // Log::info($failures);

            try {

                $mailer = Mail::class;
                $mailer::to($user)->send(new ForgotPassword($data));

                Log::info('email send ?');
                Log::info(count($mailer::failures()));

                if ($mailer::failures()) {
                    $response = [
                        'status' => 401,
                        'message' => 'Emel tidak berjaya dihantar'
                    ];
                } else {
                    //function hantar email
                    $response = [
                        'status' => 200,
                        'message' => ''
                    ];
                }

            } catch(\Swift_TransportException $transportExp){
                Log::info($transportExp);
                $transportExp->getMessage();
              }

        }

        // $response = [
        //     'status' => 200,
        //     'message' => ''
        // ];

        return $response;
    }


}
