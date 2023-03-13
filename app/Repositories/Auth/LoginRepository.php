<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginRepository
{
    public function signin($data)
    {
        $user = User::where('username', $data['username'])->first();

        if(!empty($user))
        {
            if(Hash::check($data['password'], $user->password))
            {

                $mapStatus = [
                    '02' => 'Akaun anda masih didalam semakan',
                    '03' => 'Akaun anda masih didalam menunggu pengesahan',
                    '04' => 'Akaun anda ditolak',
                    '07' => 'Akaun anda dikunci',
                    '08' => 'Akaun anda telah dibuang'
                ];

                if($user->detail){
                    if($user->detail->refStatus->code == '06'){
                        $user->update([
                            'is_login' => 1
                        ]);
                        Auth::login($user);

                        Session::put('session_user_id', $user -> id);

                        $response = [
                            'status' => 200,
                            'message' => ''
                        ];
                    } else {
                        $response = [
                            'status' => 400,
                            'message' => isset($mapStatus[$user->detail->refStatus->code]) ? $mapStatus[$user->detail->refStatus->code] : $user->detail->refStatus->desc_bm
                        ];
                    }
                } else {
                    $response = [
                        'status' => 400,
                        'message' => 'Tiada rekod'
                    ];
                }

            }else{

                $response = [
                    'status' => 400,
                    'message' => 'ID Pengguna atau Kata laluan tidak tepat'
                ];
            }
        }else {

            $response = [
                'status' => 400,
                'message' => 'Akaun tidak dijumpai'
            ];

        }

        return $response;
    }

    public function easyLogin($data)
    {
        $user = User::where('username', $data['username'])->first();

        Auth::login($user);

        Session::put('session_user_id', $user -> id);

        return [
            'status' => 200
        ];
    }
}
