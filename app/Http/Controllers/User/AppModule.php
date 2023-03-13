<?php

namespace App\Http\Controllers\User;

use App\Models\Module;
use App\Models\ModuleSubAccess;
use App\Models\RefRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AppModule extends Component
{
    public $list;

    public function mount(){
        $this->list = Module::all();
    }

    public function myModule(){

        Log::info(Auth::user()->isAdmin());
        Log::info(Auth::user()->id);

        $list = Module::whereHas('getListModuleSub', function($q){
            $q->whereHas('hasAccess', function($q2){
                $q2->whereHas('hasRole', function($q3){
                    $q3->where('model_id', Auth::user()->id);
                });
            });

            if(Auth::user()->detail->register_purpose !== ('is_jkr' || 'is_public_jkr')){
                $q->whereHas('hasModule', function($q){
                    $q->whereNotIn('code', ['04']);
                })->whereIn('code', ['01','02']);
            }

            if(!Auth::user()->isAdmin()){
                $q->whereHas('hasModule', function($q){
                    $q->whereNotIn('code', ['05']);
                });
            }

        });
        return [
            'list' => $list->get()
        ];
    }

    public function saveModuleAccess($data){

        $session_detail_id = session()->get('current_role_detail_id');

        Log::info('$session_detail_id --> '.$session_detail_id);

        for ($i=1; $i <= $data['totalSubModule']; $i++) { 
            Log::info($i);

            $moduleSubAccessId = $data['module_sub_access_id_'.$i];
            $moduleSubAccessSelf = ModuleSubAccess::find($moduleSubAccessId);

            Log::info($moduleSubAccessSelf);

            $isAll = $data['module_sub_access_id_'.$i.'_mod_fleet_a'];
            $isCreate = $data['module_sub_access_id_'.$i.'_mod_fleet_c'];
            $isRead = $data['module_sub_access_id_'.$i.'_mod_fleet_r'];
            $isUpdate = $data['module_sub_access_id_'.$i.'_mod_fleet_u'];
            $isDelete = $data['module_sub_access_id_'.$i.'_mod_fleet_d'];
            $isReport = $data['module_sub_access_id_'.$i.'_mod_fleet_report'];
            $isLimit = $data['module_sub_access_id_'.$i.'_fleet_has_limit'];

            $isAll == 'on' ? $isAll = 1 : $isAll = 0;
            $isCreate == 'on' ? $isCreate = 1 : $isCreate = 0;
            $isRead == 'on' ? $isRead = 1 : $isRead = 0;
            $isUpdate == 'on' ? $isUpdate = 1 : $isUpdate = 0;
            $isDelete == 'on' ? $isDelete = 1 : $isDelete = 0;
            $isReport == 'on' ? $isReport = 1 : $isReport = 0;
            $isLimit == 'on' ? $isLimit = 1 : $isLimit = 0;
            

            $moduleSubAccessSelf->update([
                'mod_fleet_a' => $isAll,
                'mod_fleet_c' => $isCreate,
                'mod_fleet_r' => $isRead,
                'mod_fleet_u' => $isUpdate,
                'mod_fleet_d' => $isDelete,
                'mod_fleet_report' => $isReport,
                'fleet_has_limit' => $isLimit
            ]);

        }

        $response = [
            'status' => 200,
            'detail_id' => $session_detail_id,
            'back_to_url' => route('access.roles.detail', [
                'id' => $session_detail_id,
                'tab' => 2
            ]),
            'message' => 'Maklumat Peranan berjaya disimpan.'
        ];

        return $response;

        Log::info($data);
    }

}
