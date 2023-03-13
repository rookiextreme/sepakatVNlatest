<?php

namespace App\Http\Controllers\User;

use App\Models\TaskFlow;
use App\Models\TaskFlowSubAccess;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AppTaskFlow extends Component
{
    public $list;

    public function mount(){
        $this->list = TaskFlow::orderBy('code')->get();
    }

    public function saveTaskFlowAccess($data){

        $session_detail_id = session()->get('current_role_detail_id');

        for ($i=1; $i <= $data['totalTaskFlowSub']; $i++) { 

            $taskflowSubAccessId = $data['taskflow_sub_access_id_'.$i];
            $taskflowSubAccessSelf = TaskFlowSubAccess::find($taskflowSubAccessId);

            $is_verify = $data['taskflow_sub_access_id_'.$i.'_mod_fleet_verify'];
            $is_appointment = $data['taskflow_sub_access_id_'.$i.'_mod_fleet_appointment'];
            $is_approval = $data['taskflow_sub_access_id_'.$i.'_mod_fleet_approval'];
            $is_pass = $data['taskflow_sub_access_id_'.$i.'_mod_fleet_pass'];
            $is_can_edit_after_approve = $data['taskflow_sub_access_id_'.$i.'_mod_fleet_can_edit_after_approve'];
            $is_can_dispose_federal = $data['taskflow_sub_access_id_'.$i.'_mod_fleet_can_dispose_federal'];
            $is_can_dispose_state = $data['taskflow_sub_access_id_'.$i.'_mod_fleet_can_dispose_state'];

            Log::info('$is_can_edit_after_approve => '.$is_can_edit_after_approve);
            Log::info('$is_can_dispose_federal => '.$is_can_dispose_federal);

            $taskflowSubAccessSelf->update([
                'mod_fleet_verify' => $is_verify == 'on' ? 1 : 0,
                'mod_fleet_appointment' => $is_appointment == 'on' ? 1 : 0,
                'mod_fleet_approval' => $is_approval == 'on' ? 1 : 0,
                'mod_fleet_pass' => $is_pass == 'on' ? 1 : 0,
                'mod_fleet_can_edit_after_approve' => $is_can_edit_after_approve == 'on' ? 1 : 0,
                'mod_fleet_can_dispose_federal' => $is_can_dispose_federal == 'on' ? 1 : 0,
                'mod_fleet_can_dispose_state' => $is_can_dispose_state == 'on' ? 1 : 0
            ]);

        }

        $response = [
            'status' => 200,
            'detail_id' => $session_detail_id,
            'back_to_url' => route('access.roles.detail', [
                'id' => $session_detail_id,
                'tab' => 3
            ]),
            'message' => 'Maklumat Peranan berjaya disimpan.'
        ];

        return $response;

    }

}
