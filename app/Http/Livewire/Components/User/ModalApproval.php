<?php

namespace App\Http\Livewire\Components\User;

use App\Http\Controllers\Controller;
use App\Mail\userEmailRejected;
use App\Mail\userEmailRejection;
use App\Mail\userEmailVerification;
use App\Models\RefRole;
use App\Models\RefStatus;
use App\Models\User;
use App\Models\Users\userAuditLog;
use App\Models\Users\UserVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Mailjet\MailjetTest;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class ModalApproval extends Controller
{
    public $currentRoute = "";
    public $user_id;
    public $userIds = [];
    public $roles;
    public $user_role;
    public $success = "";
    public $commentStatus = '';
    public $refStatusCode = '-1';
    public $is_confirm = false;

    public $user;
    public $isOpen = false;
    public $isUpdate = false;

    protected $listeners = [
        'closeModal',
        'userApprovalMD' => 'open',
        'userApprovalALLMD' => 'open2'
    ];

    protected $rules = [];
    protected $messages = [];

    public function open($userId, $currentRouting)
    {
        $this->currentRoute = $currentRouting;
        $this->userIds = [$userId];
        $this->isOpen = true;
    }

    public function open2($currentRouting)
    {
        $this->currentRoute = $currentRouting;
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->commentStatus = '';
        $this->success = '';
    }

    public function mount()
    {
        $this->roles = RefRole::all();
    }

    public function approve(Request $request)
    {

        Log::info($request->input('users_id'));
        $this->userIds = $request->input('users_id');
        $this->is_confirm = true;
        $this-> refStatusCode = '06';
        $this-> isUpdate = true;
        $this-> update($request);

        return response()->json([
            'message'=> $this->success
        ]);
    }

    public function reject(Request $request)
    {
        $this->userIds = $request->input('users_id');
        $this->is_confirm = true;
        $this-> refStatusCode = '04';
        $this-> isUpdate = true;
        $this-> update($request);

        return response()->json([
            'message'=> $this->success
        ]);
    }

    public function setRole(Request $request){

        foreach ($this-> userIds as $user_id) {
            $user = User::find($user_id);
            $user -> roles() -> detach();
            $user->assignRole($this->user_role);
        }
        return redirect()->to('/user/approval');
    }

    public function update(Request $request)
    {

        //dd($this->user_role);

        Log::info($this->userIds);

        foreach ($this-> userIds as $user_id) {
            $user = User::find($user_id);
            $refStatus = RefStatus::where('code',$this-> refStatusCode)->first();
            $user->detail()->update([
                'ref_status_id' =>  $refStatus->id
            ]);

            $userAuditLog = userAuditLog::where('user_id', $user_id);
            $userAuditLog -> update(
                [
                    'status' => false
                ]
            );

            $actionBy = Session::get('session_user_id');

            userAuditLog::create([
                'user_id' => $user_id,
                'action_by' => $actionBy,
                'ref_status_id' =>  $refStatus->id,
                'comment' => $this->commentStatus,
                'status' => true
            ]);
            $this->success = 'Status rekod dikemaskini!';

            if($this-> refStatusCode == '06'){

                Log::info('hi mailer '.$this->refStatusCode);
                $token = sha1(uniqid(time(), true));

                $url = route('activation.user', [
                    "token" => $token,
                    "view" => 'create'
                ]);

                $data = [
                    'from' => env('MAIL_FROM_NAME'),
                    'subject' => 'Pengaktifan Akaun Spakat',
                    'title'=> '',
                    'body' => 'asdsd',
                    'fullname' => $user-> name,
                    'url' => $url
                ];

                Log::info('$url UserVerification --> '.$url);

                UserVerification::create([
                    'user_id'=> $user_id,
                    'token' => $token,
                    'status' => true,
                    'expired_token' => Carbon::now()->addDays(3)
                ]);
                
                Mail::to($user)->send(new userEmailVerification($data));
            } else if($this-> refStatusCode == '04'){

                $data = [
                    'from' => env('MAIL_FROM_NAME'),
                    'subject' => 'Pengaktifan Akaun Spakat',
                    'title'=> 'Akaun anda telah dibatalkan',
                    'reason' => $request->rejectComment
                ];
                
                $user->update(['email' => 'xxx-'.$user->email]);
                
                Mail::to($user)->send(new userEmailRejection($data));
            }
        }

    }

    public function render()
    {
        return view('livewire.components.user.modal-approval');
    }
}
