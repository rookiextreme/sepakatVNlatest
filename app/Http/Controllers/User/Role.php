<?php

namespace App\Http\Controllers\User;

use App\Models\Module;
use App\Models\ModuleSub;
use App\Models\ModuleSubAccess;
use Spatie\Permission\Models\Role as PublicRole;
use App\Http\Controllers\User\Registered as UserRegisteredDAO;
use Illuminate\Http\Request;
use App\Models\RefRole;
use App\Models\RefRoleAccess;
use App\Models\RefWorkshop;
use App\Models\TaskFlowSub;
use App\Models\TaskFlowSubAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Role extends Component
{
    public $detail;
    public $roles_access;
    public $newCode;
    public $workshop_list;

    public function mount(){
        $this->roles_access = RefRoleAccess::all();
        $this->workshop_list = RefWorkshop::orderByRaw('code=\'02\'')->get()->reverse();
    }

    public function generateNewCode(){
        $role = RefRole::latest('id')->first();
        Log::info('$role --> '.$role);

        $this->newCode = sprintf("%02d", (int)($role->code) + 1);

        Log::info('$this->newCode --> '.$this->newCode);
    }

    public function saveDefinition($data){

        $role = "";
        $session_detail_id = session()->get('current_role_detail_id');

        Log::info('$session_detail_id --> '.$session_detail_id);

        if($session_detail_id != 'register'){
            $role = RefRole::where('id', $session_detail_id)->first();
        }

        if($data['role_access_id'] == 4){
            $user_list = [];
    
            foreach ($role->hasManyRoles as $key => $item) {
                array_push($user_list, $item->hasUser->id);
            }
    
            Log::info('user_list => ', $user_list);

            $UserRegisteredDAO = new UserRegisteredDAO();
            $req = new Request([
                'role_id' => $role->id,
                'purpose_type' => 'is_public',
                'users_id' => $user_list,
            ]);
    
            Log::info($req->all());
            Log::info($UserRegisteredDAO->setRole($req));
        }

        if(empty($role)){

            $this->generateNewCode();

            Log::info($data);

            $roleRoleData = RefRole::create([
                'code' => $this->newCode,
                'desc_bm' => $data['role_name'],
                'task_desc_bm' => $data['desc'],
                'ref_role_access_id' => $data['role_access_id'],
                'workshop_id' => $data->workshop_id,
                'can_delete' => true
            ]);

            $publicRolelatest = PublicRole::latest('id')->first();

            Log::info($publicRolelatest -> id);

            PublicRole::create(['name' => $this->newCode]);

            $module_sub_list = ModuleSub::all();

            foreach ($module_sub_list as $submodule) {

                ModuleSubAccess::insert([
                    'module_sub_id' => $submodule->id,
                    'created_by' => Auth::user()->id,
                    'role_id' => $roleRoleData->id
                ]);
            };

            $taskflow_sub_list = TaskFlowSub::all();

            foreach ($taskflow_sub_list as $taskflow_sub) {

                TaskFlowSubAccess::insert([
                    'taskflow_sub_id' => $taskflow_sub->id,
                    'created_by' => Auth::user()->id,
                    'role_id' => $roleRoleData->id
                ]);
            };

            $response = [
                'status' => 200,
                'detail_id' => $roleRoleData->id,
                'back_to_url' => route('access.roles.detail', [
                    'id' => $roleRoleData->id,
                    'tab' => 1
                ]),
                'message' => 'Maklumat Peranan berjaya dicipta.'
            ];

            Log::info($response);

            return $response;

        } else {
            $role->update([
                'desc_bm' => $data['role_name'],
                'task_desc_bm' => $data['desc'],
                'ref_role_access_id' => $data['role_access_id']
            ]);

            $response = [
                'status' => 200,
                'detail_id' => $session_detail_id,
                'back_to_url' => route('access.roles.detail', [
                    'id' => $session_detail_id,
                    'tab' => 1
                ]),
                'message' => 'Maklumat Peranan berjaya disimpan.'
            ];

            return $response;
        }
    }

    public function loadDetail($id){

        Log::info(' asas '.is_int($id));

        if($id){
            Log::info('loadDetail and set session current_role_detail_id -> '.$id);
            session()->put('current_role_detail_id', $id);
    
            Log::info('loadDetail and get session current_role_detail_id -> '.session()->get('current_role_detail_id'));
            Log::info(session()->get('current_role_detail_id'));
            $this->detail = RefRole::where('id', $id)->first();
        } else {
            session()->put('current_role_detail_id', $id);
            $this->generateNewCode();
        }
    }

}
