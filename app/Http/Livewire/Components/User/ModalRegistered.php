<?php

namespace App\Http\Livewire\Components\User;

use App\Models\RefStatus;
use App\Models\User;
use App\Models\Users\userAuditLog;
use App\Models\Users\userLockAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalRegistered extends Component
{
    public $currentRoute = "";
    public $user_id;
    public $success;
    public $end_dt = "";
    public $commentStatus;
    public $refStatusCode = '-1';

    public $user;
    public $isOpen = false;

    protected $listeners = [
        'closeModal',
        'userRegisteredMD' => 'open',
    ];

    protected $rules = [
        'end_dt' => 'required',
        'commentStatus' => 'required'
    ];

    public function open($userId, $currentRouting)
    {
        $this->currentRoute = $currentRouting;
        $this->user_id = $userId;
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->commentStatus = '';
        $this->success = '';
        if($this->currentRoute != ""){
            redirect()->to($this->currentRoute);
        }
    }

    public function mount()
    {
        $this->success = '';
    }

    public function revoke()
    {
        $this-> refStatusCode = '08';
        $this-> update();
    }

    public function lock(Request $request)
    {

        // dd("waaa --> ". $this->end_dt  . $this->commentStatus);
        $this->validate();
        $this-> refStatusCode = '07';
        $this-> update();
    }

    public function update()
    {

        $user = User::find($this->user_id);
        $refStatus = RefStatus::where('code',$this-> refStatusCode)->first();
        $user->detail()->update([
            'ref_status_id' =>  $refStatus->id
        ]);

        $userAuditLog = userAuditLog::where('user_id', $this->user_id);
        $userAuditLog -> update(
            [
                'status' => false
            ]
        );

        $actionBy = Session::get('session_user_id');
        if($this->refStatusCode == '07'){

            $userLockAccess = userLockAccess::where('user_id', $this->user_id);
            $userLockAccess -> update(
                [
                    'status' => false
                ]
            );

            userLockAccess::create([
                'user_id' => $this->user_id,
                'ref_status_id' =>  $refStatus->id,
                'from_dt' => date('Y-m-d'),
                'end_dt' => Carbon::parse($this->end_dt)->format('Y-m-d'),
                'status' => true
            ]);
        }

        userAuditLog::create([
            'user_id' => $this->user_id,
            'action_by' => $actionBy,
            'ref_status_id' =>  $refStatus->id,
            'comment' => $this->commentStatus,
            'status' => true
        ]);
        $this->success = 'Status rekod dikemaskini!';
    }

    public function render()
    {
        return view('livewire.components.user.modal-registered');
    }
}
