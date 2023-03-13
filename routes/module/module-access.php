<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Components\User\ModalApproval;
use App\Models\RefRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\User\Role as RoleDAO;
use App\Http\Controllers\User\AppModule as AppModuleDAO;
use App\Http\Controllers\User\Approval;
use App\Http\Controllers\User\AppTaskFlow;
use App\Http\Controllers\User\Registered as UserRegisteredDAO;
use App\Models\Fleet\FleetAudit;
use App\Models\FleetPlacement;
use App\Models\RefWorkshop;
use Illuminate\Support\Str;

Route::group(['prefix' => 'access', 'as' => 'access', 'middleware' => 'auth'],function(){


    Route::group(['prefix' => 'roles', 'as' => '.roles', 'middleware' => 'auth'], function(){

        Route::get('/list', function(Request $request){
            if (Auth::user()->roleAccess()->code == '01') {

                $queryRole = RefRole::orderBy('code', 'asc');

                if($request->search){
                    $queryRole
                    ->whereRaw('upper(desc_bm) like \'%'.Str::upper($request->search).'%\'')
                    ->orWhereRaw('upper(task_desc_bm) like \'%'.Str::upper($request->search).'%\'');
                }

                $roles = $queryRole->paginate(10);
                return view('access.roles.list', ['roles' => $roles, 'total' => RefRole::count()]);
            }
        })->name('.list');

        Route::get('/register', function(){
            return view('access.roles.register');
        })->name('.register');

        Route::get('/detail/{id}', function(){
            return view('access.roles.register');
        })->name('.detail');

        Route::get('/overview', function(){
            return view('access.roles.overview');
        })->name('.overview');

        Route::post('/detail/save', function(Request $request){

            $section = $request->input('section');
            switch ($section) {
                case 'definition':

                    $request->validate([
                        'role_name' => 'required',
                        'workshop_id' => 'required',
                        'desc' => 'required',
                        'role_access_id' => 'required',
                    ], [
                        'role_name.required' => 'Sila masukkan nama peranan',
                        'workshop_id.required' => 'Sila pilih woksyop',
                        'desc.required' => 'Sila masukkan keterangan peranan',
                        'role_access_id.required' => 'Sila pilih akses peranan',
                    ]);

                    $roleDAO = new RoleDAO();
                    return $roleDAO->saveDefinition($request);
                    break;

                case 'access_sub_module':
                    $AppModuleDAO = new AppModuleDAO();
                    return $AppModuleDAO->saveModuleAccess($request);
                    break;

                case 'workflow':
                    $AppTaskFlowDAO = new AppTaskFlow();
                    return $AppTaskFlowDAO->saveTaskFlowAccess($request);
                    break;

                default:
                    # code...
                    break;
            }
        })->name('.detail.save');

    });

    Route::group(['prefix' => 'user', 'as' => '.user', 'middleware' => 'auth'], function(){

        Route::get('/ajax/getModalUserDetail', function(Request $request){
            $user_id = $request->user_id;
            $query = User::find($user_id);
            Log::info($query);
            return view('access.user.approval.tab.view-userdetail',[
                'user' => $query
            ]);
        })->name('.ajax.getModalUserDetail');


        Route::get('/ajax/getPlacement', function(Request $request){
            return FleetPlacement::select('id','desc')->where('ref_state_id', $request->state_id)->get();
        })->name('.ajax.getPlacement');

        Route::get('/overview', function(){
            return view('access.user.overview');
        })->name('.overview');

        Route::get('/approval', function(){
            return view('access.user.approval');
        })->name('.approval');

        Route::get('/approval/detail/{id}', function(){
            return view('access.user.approval.detail');
        })->name('.approval.detail');

        Route::post('/approval/approve', function(Request $request){
            $ModalApproval = new ModalApproval();
            return $ModalApproval->approve($request);
        })->name('.approval.approve');

        Route::post('/approval/reject', function(Request $request){
            $ModalApproval = new ModalApproval();
            return $ModalApproval->reject($request);
        })->name('.approval.reject');

        Route::get('/approval/list', function(Request $request){
            $ApprovalDAO = new Approval();
            $register_purpose = $request->register_purpose;
            $users = $ApprovalDAO->getUsers($register_purpose);
            return view('access.user.approval.tab.list', [
                'users' => $users,
                'register_purpose' => $register_purpose
            ]);
        })->name('.approval.list');

        Route::get('/registered', function(Request $request){
            $UserRegisteredDAO = new UserRegisteredDAO();
//            echo '<pre>';
//            print_r($UserRegisteredDAO->detail($request));
//            echo '</pre>';
//            die();
            return view('access.user.registered', $UserRegisteredDAO->detail($request));
        })->name('.registered');

        Route::get('/registered/detail/{id}', function(){
            return view('access.user.registered.detail');
        })->name('.registered.detail');

        Route::get('/registered/list', function(Request $request){
            $RegisteredDAO = new UserRegisteredDAO();
            $register_purpose = $request->register_purpose;
            $users = $RegisteredDAO->getUsers($request);
            return view('access.user.registered.tab.list', [
                'users' => $users,
                'register_purpose' => $register_purpose
            ]);
        })->name('.registered.list');

        Route::post('/registered/setRole', function(Request $request){

            $UserRegisteredDAO = new UserRegisteredDAO();
            return $UserRegisteredDAO->setRole($request);

        })->name('.registered.setRole');

        Route::post('/registered/setWorkshop', function(Request $request){

            $UserRegisteredDAO = new UserRegisteredDAO();
            return $UserRegisteredDAO->setWorkshop($request);

        })->name('.registered.setWorkshop');

        Route::post('/registered/revoke', function(Request $request){

            $UserRegisteredDAO = new UserRegisteredDAO();
            return $UserRegisteredDAO->revoke($request);

        })->name('.registered.revoke');

        Route::get('/revoked', function(){
            return view('access.user.revoked');
        })->name('.revoked');

        Route::get('/locked', function(){
            return view('access.user.locked');
        })->name('.locked');

        Route::post('/registered/resendLinkVerifyUser', function(Request $request){

            $UserRegisteredDAO = new UserRegisteredDAO();
            return $UserRegisteredDAO->resendLinkVerifyUser($request);

        })->name('.registered.resendLinkVerifyUser');

        Route::get('/farid', function(){

            $email = 'farid.developer.1993@gmail.com';

            $user = DB::select('SELECT a.email FROM users.users a
            JOIN users.details b ON b.user_id = a.id  where a.email = ? ', [
                $email
            ]);
            return $user;
        });

    });

     //Add Jejak Pengguna
     Route::get('/audit_list', function(){
        $audit_trail_list = FleetAudit::orderBy('audit_ts','desc');
        $audit_trail_list->whereIn('operation', ["UPDATE", "DELETE"]);

        return view('access.audit.audit_list', [
            'audit_trail_list' => $audit_trail_list->paginate(5)
        ]);
    })->name('.audit_list');

    Route::get('/my_module', function(){
        $AppModuleDAO = new AppModuleDAO();
        return view('access.module.my_module', $AppModuleDAO->myModule());
    })->name('.my_module');

});
