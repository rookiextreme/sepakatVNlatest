<?php

namespace App\Models;

use App\Http\Controllers\Logistic\Booking\LogisticBookingDAO;
use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyDAO;
use App\Models\DisasterReady\DisasterReadyBooking;
use App\Models\Logistic\LogisticBooking;
use App\Models\Users\Detail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    protected $table = 'users.users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nickname',
        'username',
        'email',
        'password',
        'created_at',
        'email_verified_at',
        'session_key',
        'is_sso',
        'login_from_sso',
        'owner_type_id',
        'is_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function roleAccess(){

        $dashboard_codes = [];

        foreach (Auth::user()->roles as $index => $key) {
            array_push($dashboard_codes, $key->name);
        }

        $RefRole = RefRole::whereIn('code', $dashboard_codes)->whereHas('roleAccess', function($q){
            $q->orderBy('code', 'asc');
        })->get()->first();

        $refRoleAccessDetail = RefRoleAccess::find($RefRole->ref_role_access_id);
        return $refRoleAccessDetail;
    }

    public function checkRole($role)
    {
        $has_role = ModelHasRole::whereHas('hasRole', function($q) use($role){
            $q->whereHas('hasRefRole', function($q) use($role){
                $q->where('code', $role);
            });
        })
        ->where('model_id', Auth::user()->id)
        ->with('hasRole')
        ->first();
        return $has_role;
    }

    public function detail()
    {
        return $this->hasOne(Detail::class, 'user_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Users\UserStatus');
    }

    public function isAdmin(){
        return $this->roleAccess()->code == '01' ? true: false;
    }

    public function isTopManagement(){
        return $this->roleAccess()->code == '02' ? true: false;
    }

    public function isSeniorEngineer(){
        return $this->roleAccess()->code == '03' && $this->checkRole('09') ? true: false;
    }
    public function isSeniorEngineerMaintenance(){
        return $this->roleAccess()->code == '03' && $this->checkRole('10')? true: false;
    }

    public function isEngineer(){
        return $this->roleAccess()->code == '03' && $this->checkRole('03') ? true: false;
    }
    public function isEngineerAssessment(){
        return $this->roleAccess()->code == '03' && $this->checkRole('14')? true: false;
    }
    public function isEngineerMaintenance(){
        return $this->roleAccess()->code == '03' && $this->checkRole('11')? true: false;
    }

    public function isAssistEngineer(){
        return $this->roleAccess()->code == '03' && $this->checkRole('04')? true: false;
    }
    public function isAssistEngineerAssessment(){
        return $this->roleAccess()->code == '03' && $this->checkRole('15')? true: false;
    }
    public function isAssistEngineerMaintenance(){
        return $this->roleAccess()->code == '03' && $this->checkRole('12')? true: false;
    }

    public function isForemenAssessment(){
        return $this->roleAccess()->code == '03' && $this->checkRole('07')? true: false;
    }

    public function isForemenMaintenance(){
        return $this->roleAccess()->code == '03' && $this->checkRole('08')? true: false;
    }

    public function isPublic(){
        return $this->roleAccess()->code == '04' && $this->checkRole('05')? true: false;
    }

    public function isDriver(){
        return $this->roleAccess()->code == '04' && $this->checkRole('06')? true: false;
    }

    public function isCoordinator(){
        return $this->access('05', '01')->fleet_has_limit == 1 ? true : false;
        // return $this->roleAccess()->code == '03' && $this->checkRole('17')? true: false;
    }

    public function isVehicleOfficer(){
        return $this->roleAccess()->code == '03' && $this->checkRole('16')? true: false;
    }

    public function access($module_code, $module_sub_code)
    {
        $role_id = auth()->user()->roles->first()->id;
        $module = Module::where('code', $module_code)->first();
        $moduleSub = ModuleSub::where([
            'module_id' => $module->id,
            'code' => $module_sub_code
        ])->first();
        $moduleSubAccess = ModuleSubAccess::where([
            'module_sub_id' => $moduleSub->id,
            'role_id' => $role_id
        ])->first();
        return $moduleSubAccess;
    }

    public function vehicle($module_code, $module_sub_code)
    {
        $role_ids = [];

        foreach (auth()->user()->roles as $roles) {
            array_push($role_ids, $roles->id);
        }

        $module = Module::where('code', $module_code)->first();
        $moduleSub = ModuleSub::where([
            'module_id' => $module->id,
            'code' => $module_sub_code
        ])->first();

        $moduleSubAccess = null;

        if($moduleSub){
            $moduleSubAccess = ModuleSubAccess::where([
                'module_sub_id' => $moduleSub->id
            ])->whereIn('role_id', $role_ids);
        }

        $ModuleSubAccess = new ModuleSubAccess();

        $mod_fleet_a = 0;
        $mod_fleet_c = 0;
        $mod_fleet_r = 0;
        $mod_fleet_u = 0;
        $mod_fleet_d = 0;
        $fleet_has_limit = 0;

        if($moduleSubAccess){
            foreach ($moduleSubAccess->get() as $key) {
                if($key->mod_fleet_a){
                    $mod_fleet_a = $key->mod_fleet_a;
                }
                if($key->mod_fleet_c){
                    $mod_fleet_c = $key->mod_fleet_c;
                }
                if($key->mod_fleet_r){
                    $mod_fleet_r = $key->mod_fleet_r;
                }
                if($key->mod_fleet_u){
                    $mod_fleet_u = $key->mod_fleet_u;
                }
                if($key->mod_fleet_d){
                    $mod_fleet_d = $key->mod_fleet_d;
                }
                if($key->fleet_has_limit){
                    $fleet_has_limit = $key->fleet_has_limit;
                }
            }
        }

        $ModuleSubAccess->mod_fleet_a = $mod_fleet_a;
        $ModuleSubAccess->mod_fleet_c = $mod_fleet_c;
        $ModuleSubAccess->mod_fleet_r = $mod_fleet_r;
        $ModuleSubAccess->mod_fleet_u = $mod_fleet_u;
        $ModuleSubAccess->mod_fleet_d = $mod_fleet_d;
        $ModuleSubAccess->fleet_has_limit = $fleet_has_limit;

        return $ModuleSubAccess;
    }

    public function vehicleWorkFlow($taskflow_code, $taskflow_sub_code)
    {
        $role_ids = [];

        foreach (auth()->user()->roles as $roles) {
            array_push($role_ids, $roles->id);
        }

        $taskflow = TaskFlow::where('code', $taskflow_code)->first();
        $taskflowSub = TaskFlowSub::where([
            'taskflow_id' => $taskflow->id,
            'code' => $taskflow_sub_code
        ])->first();

        $access = TaskFlowSubAccess::where([
            'taskflow_sub_id' => $taskflowSub->id
        ])->whereIn('role_id', $role_ids);

        $taskflowSubAccess = new TaskFlowSubAccess();

        $mod_fleet_verify = 0;
        $mod_fleet_appointment = 0;
        $mod_fleet_approval = 0;
        $mod_fleet_pass = 0;
        $mod_fleet_can_edit_after_approve = 0;
        $mod_fleet_can_dispose_federal = 0;
        $mod_fleet_can_dispose_state = 0;

        foreach ($access->get() as $key) {
            if($key->mod_fleet_verify){
                $mod_fleet_verify = $key->mod_fleet_verify;
            }
            if($key->mod_fleet_appointment){
                $mod_fleet_appointment = $key->mod_fleet_appointment;
            }
            if($key->mod_fleet_approval){
                $mod_fleet_approval = $key->mod_fleet_approval;
            }
            if($key->mod_fleet_pass){
                $mod_fleet_pass = $key->mod_fleet_pass;
            }
            if($key->mod_fleet_can_edit_after_approve){
                $mod_fleet_can_edit_after_approve = $key->mod_fleet_can_edit_after_approve;
            }
            if($key->mod_fleet_can_dispose_federal){
                $mod_fleet_can_dispose_federal = $key->mod_fleet_can_dispose_federal;
            }
            if($key->mod_fleet_can_dispose_state){
                $mod_fleet_can_dispose_state = $key->mod_fleet_can_dispose_state;
            }
        }

        $taskflowSubAccess->mod_fleet_verify = $mod_fleet_verify;
        $taskflowSubAccess->mod_fleet_appointment = $mod_fleet_appointment;
        $taskflowSubAccess->mod_fleet_approval = $mod_fleet_approval;
        $taskflowSubAccess->mod_fleet_pass = $mod_fleet_pass;
        $taskflowSubAccess->mod_fleet_can_edit_after_approve = $mod_fleet_can_edit_after_approve;
        $taskflowSubAccess->mod_fleet_can_dispose_federal = $mod_fleet_can_dispose_federal;
        $taskflowSubAccess->mod_fleet_can_dispose_state = $mod_fleet_can_dispose_state;

        return $taskflowSubAccess;
    }

    public function generalSetting($code){
        return RefSetting::where('code', $code)->first();
    }

    public function pendaftaran()
    {
        return $this->hasMany('App\Models\Kenderaan\Pendaftaran');
    }

    public function maklumatKenderaanSaman()
    {
        return $this->hasMany('App\Models\Saman\MaklumatKenderaanSaman');
    }

    public function getRoleDesc($roleKey){
        $role = RefRole::where("code", $roleKey)->first();
        return $role;
    }

    public function hasOwnRole($user_id){
        $query = $this->select('ref_role.id AS role_id','ref_role.desc_bm AS designation', 'ref_role.task_desc_bm AS designation_task')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.users.id')
            ->join('ref_role', 'ref_role.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $user_id)
            ->first();
        return $query;
    }

    public function hasRole(){
        $query = $this->select('ref_role.id AS role_id','ref_role.desc_bm AS designation', 'ref_role.task_desc_bm AS designation_task')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.users.id')
            ->join('ref_role', 'ref_role.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', Auth::user()->id)
            ->first();
        return $query;
    }

    public function hasManyApprovalByModule($taskflow_code, $taskflow_sub_code, $branchId){

        $taskflow = TaskFlow::where('code', $taskflow_code)->first();
        $taskflowSub = TaskFlowSub::where([
            'taskflow_id' => $taskflow->id,
            'code' => $taskflow_sub_code
        ])->first();

        $access = TaskFlowSubAccess::where([
            'taskflow_sub_id' => $taskflowSub->id,
            'mod_fleet_approval' => true
        ])
        ->whereHas('hasManyRoles', function($q)use($branchId){
            $q->whereHas('hasUser', function($q1)use($branchId){
                $q1->whereHas('detail', function($q2)use($branchId){
                    $q2->whereHas('jkrStaff', function($q3)use($branchId){
                        $q3->where('branch_id', $branchId);
                    })->whereHas('refStatus', function($q2){
                        $q2->where('code', '06');
                    });
                });
            });
        })->with('hasManyRoles');

        return $access->get();

    }

    public function hasManyApprovalByModuleFilterAgency($taskflow_code, $taskflow_sub_code, $agencyId){

        $taskflow = TaskFlow::where('code', $taskflow_code)->first();
        $taskflowSub = TaskFlowSub::where([
            'taskflow_id' => $taskflow->id,
            'code' => $taskflow_sub_code
        ])->first();

        $access = TaskFlowSubAccess::where([
            'taskflow_sub_id' => $taskflowSub->id,
            'mod_fleet_approval' => true
        ])
        ->whereHas('hasManyRoles', function($q)use($agencyId){
            $q->whereHas('hasUser', function($q1)use($agencyId){
                $q1->whereHas('detail', function($q2)use($agencyId){
                    $q2->whereHas('govAgencyStaff', function($q3)use($agencyId){
                        $q3->where('agency_id', $agencyId);
                    })->whereHas('refStatus', function($q2){
                        $q2->where('code', '06');
                    });
                });
            });
        })->with('hasManyRoles');

        return $access->get();

    }

    public function hasManyApprovalByModuleFilterWorkshop($taskflow_code, $taskflow_sub_code, $workshopId){

        $taskflow = TaskFlow::where('code', $taskflow_code)->first();
        $taskflowSub = TaskFlowSub::where([
            'taskflow_id' => $taskflow->id,
            'code' => $taskflow_sub_code
        ])->first();

        $access = TaskFlowSubAccess::where([
            'taskflow_sub_id' => $taskflowSub->id,
            'mod_fleet_approval' => true
        ])
        ->whereHas('hasManyRoles', function($q)use($workshopId){
            $q->whereHas('hasUser', function($q1)use($workshopId){
                $q1->whereHas('detail', function($q2)use($workshopId){
                    $q2->where('workshop_id', $workshopId)
                    ->whereHas('refStatus', function($q2){
                        $q2->where('code', '06');
                    });
                });
            });
        })->with('hasManyRoles');

        return $access->get();

    }

    public function totalLogisticBooking(Request $request){

        $LogisticBookingDAO = new LogisticBookingDAO();
        $total = 0;
        $totalVerification = LogisticBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['02','03']);
        });

        $totalDraft = LogisticBooking::whereHas('hasBookingStatus', function($q){
            $q->where('code', '01');
        })->where('created_by', Auth::user()->id);

        $totalVerification = $LogisticBookingDAO->filterByVehicle($totalVerification, $request);

        $total = $totalVerification->count() + $totalDraft->count();

        return $total;
    }

    public function totalLogisticBookingDisaster(Request $request){

        $DisasterReadyDAO = new DisasterReadyDAO();
        $total = 0;
        $totalVerification = DisasterReadyBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['02','03']);
        });

        $totalDraft = DisasterReadyBooking::whereHas('hasBookingStatus', function($q){
            $q->where('code', '01');
        })->where('created_by', Auth::user()->id);

        $totalVerification = $DisasterReadyDAO->filterByVehicle($totalVerification, $request);
        $total = $totalVerification->count() + $totalDraft->count();

        return $total;
    }

}
