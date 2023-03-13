<?php

namespace App\Http\Livewire\Components\User;

use App\Models\RefStatus;
use App\Models\User;
use App\Models\Users\userAuditLog;
use Illuminate\Support\Facades\Session;
use Livewire\Component;


class ModalLocked extends Component
{
    public $currentRoute = "";
    public $user_id;
    public $success;
    public $commentStatus = '';
    public $refStatusCode = '-1';

    public $user;
    public $isOpen = false;

    protected $listeners = [
        'closeModal',
        'userLockedMD' => 'open'
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

    public function giveAccess()
    {
        $this-> refStatusCode = '06';
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
        return view('livewire.components.user.modal-locked');
    }
}
