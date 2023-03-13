<?php

namespace App\Http\Livewire\Auth\Activation;

use App\Models\User as ModelsUser;
use App\Models\Users\UserVerification;
use Livewire\Component;
use App\Repositories\Auth\LoginRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class User extends Component
{
    
    public $fullname;
    public $username;
    public $password;
    public $repassword;
    public $token;
    public $message = "";
    public $linkExpired = false;
    public $attributes = [];
    public $user;
    public $displayForm = true;
    public $is_create = false;
    public $is_forgot_pass = false;
    public $is_change_password = false;

    protected $rules = [];

    public function mount(Request $request){

        if($request->input('view') == 'create'){
            $this->is_create = true;
        } else if($request->input('view') == 'forgot_password'){
            $this->is_forgot_pass = true;
        } else if($request->input('view') == 'change_password'){
            $this->is_change_password = true;
        }

        $this->token = $request->input('token');

        $user = UserVerification::all()->where("token",$this->token)->first();

        if($this->is_change_password){
            $this->fullname = auth()->user()->name;
            $this->username = auth()->user()->username;
        } else {
        
            if(empty($user)){
                $this->message = "Something When Wrong";
                $this->displayForm = false;
            }
            else if(($user && !$user->status) || ($user && Carbon::now()->format('Y-m-d 00:00:00') > Carbon::parse($user->expired_token))){
                Log::info('asas');
                $this->linkExpired = true;
                $this->displayForm = false;
                $this->message = "Link has been expired";
            } else {
                $userDetail = ModelsUser::find($user->user_id);
                Log::info("ada x ? \n");
                Log::info($userDetail);
                $this->fullname = $userDetail->name;
                $this->username = $userDetail->username;
            }

            Log::info("user ".$user);
            Log::info("token ".$this->token);

        }
    }

    public function save(){

        if($this->is_create){
            $this->rules = [
                'password' => 'required|min:8|max:20|required_with:repassword',
                'repassword' => 'required|same:password|required_with:password'
            ];  
        } else {
            $this->rules = [
                'password' => 'required|min:8|max:20|required_with:repassword',
                'repassword' => 'required|same:password|required_with:password'
            ];      
        }

        $this->messages =[
            'username.required' => 'Sila masukkan ID Pilihan baru.',
            'username.unique' => 'ID Pilihan sudah wujud.',
            'password.required' => 'Sila masukkan kata laluan.',
            'repassword.required' => 'Sila ulang kata laluan.',
            'password.required_with' => 'Kata laluan yang di masukkan mestilah sama',
            'repassword.required_with' => 'Kata laluan yang di masukkan mestilah sama',
            'password.same' => 'Kata laluan yang di masukkan mestilah sama',
            'repassword.same' => 'Kata laluan yang di masukkan mestilah sama',
            'password.min' => 'Kata laluan yang di masukkan mestilah lebih daripada 8 aksara',
            'repassword.min' => 'Kata laluan yang di masukkan mestilah lebih daripada 8 aksara',
            'password.max' => 'Kata laluan yang di masukkan tidak melebihi daripada 20 aksara',
            'repassword.max' => 'Kata laluan yang di masukkan tidak melebihi daripada 20 aksara'
        ];

        $this->username = preg_replace('/\s+/', '', $this->username);

        $checkAvailableUser = ModelsUser::where('username', $this->username)
        ->whereHas('detail', function($detail){
            $detail->whereHas('refStatus', function($status){
                $status->whereNotIn('code', ['04','08']);
            });
        })
        ->first();

        if($checkAvailableUser && !$this->is_forgot_pass && !$this->is_change_password){
            $this->message = "ID Pilihan sudah wujud.";
        } else{

            $this->validate();

            if($this->is_change_password){
                ModelsUser::find(auth()->user()->id)->update(
                    [
                        'password' => Hash::make($this->password)
                    ]
                );
                $this->message = "Penukaran Kata Laluan berjaya.";
                return redirect()->route('login', [
                    'message' => $this->message
                ]);
            } else {
                $userVerify = UserVerification::all()->where('token', $this->token)->first();

                if($userVerify->status){
    
                    $userVerify-> update([
                        'status' =>  false
                    ]);
    
                    $user = ModelsUser::find($userVerify->user_id);
    
                    Log::info('username --> '.$this->username);
            
                    ModelsUser::find($userVerify->user_id)->update(
                        [
                            'username' => $this->username,
                            'password' => Hash::make($this->password),
                            'email_verified_at' => Carbon::now()
                        ]
                    );
    
                    if($this->is_create){
                        $this->message = "Akaun berjaya dicipta.";
                    } else {
                        $this->message = "Penukaran Kata Laluan berjaya.";
                    }
    
                    return redirect()->route('login', [
                        'message' => $this->message
                    ]);
                } else {
                    $this->message = "Akaun telah disahkan";
                }
            }
        }
        
    }

    public function render()
    {
        return view('livewire.auth.activation.user', [
            'linkExpired' => $this->linkExpired,
            'message' => $this->message
        ]);
    }
}
