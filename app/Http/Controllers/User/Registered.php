<?php

namespace App\Http\Controllers\User;

use App\Mail\ForgotPassword;
use App\Mail\userEmailVerification;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefRole;
use App\Models\RefStatus;
use App\Models\RefWorkshop;
use App\Models\User;
use App\Models\Users\Detail;
use App\Models\Users\UserVerification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;

class Registered extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $limitPage = 5;
    public $tab = 'kakitangan';
    public $register_purpose;
    public $role_id;
    public $lang = 'bm';

    public function getUsers($request){
        Log::info('/getUsers');
        Log::info($request);
        $this->register_purpose = $request->register_purpose;
        $this->role_id = $request->role_id;
        Log::info($this->role_id);

        $search = $request->search ? $request->search : null;
        $query = User::whereHas('detail', function($q){
            $q->where('register_purpose', $this->register_purpose)
                ->whereHas('refStatus', function($q2){
                    $q2->where('code', '06');
                });
            });

            if($request->acc_unverified == 1){
                $query->where('username', null);
            } else {
                $query->whereNotNull('username');
            }

            $query->whereHas('roles', function($q){
                if($this->role_id){
                    $q->where('id',$this->role_id);
                }
            });

            if(Auth::user()->isCoordinator()){
                $query->whereHas('detail', function($q){
                    $q->whereHas('hasWorkshop', function($q2){
                        $q2->where('id', Auth::user()->detail->hasWorkshop->id);
                    });
                });
            }

            if($search!=null){
                $query->whereRaw("upper(name) LIKE '%".strtoupper($request->search)."%' ")
                ->orWhereHas('detail', function($q) use($request){
                    $q->whereRaw("upper(identity_no) LIKE '%".strtoupper($request->search)."%' ");
                });
            }

            if($request->sort_by){
                $sort_field = $request->sort_field ? $request->sort_field : 'name';
                $query->orderBy($sort_field, $request->sort_by);
            }

        return $query->paginate(10);
    }

    public function setRole(Request $request){

        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'purpose_type' => 'required',
        ], [
            'role_id.required' => 'Sila pilih peranan',
            'purpose_type.required' => 'Sila pilih jenis akses'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $result = 0;
        $totalUpdated = 0;

        $userIds = $request['users_id'] ? $request['users_id'] : [];
        $role_id = $request['role_id'] ? $request['role_id'] : -1;

        $roles = RefRole::whereIn('id', explode(',', $role_id))->orderBy('code','desc')->get();
        $purpose_type = $request->purpose_type;
        // $ref_role_id = 5;

        // foreach ($roles as $role) {
        //     $ref_role_id = $role->id;
        // }

        foreach ($userIds as $user_id) {
            $user = User::find($user_id);

            $user->detail->update([
                'register_purpose' => $purpose_type,
            ]);

            $user->syncRoles(explode(',', $role_id));
            $totalUpdated++;
        }

        if(count($userIds) == $totalUpdated){
            $result = [
                'message' => 'Tetapan peranan telah disimpan'
            ];
        }
        return $result;
    }

    public function setWorkshop(Request $request){

        $result = 0;

        $userIds = $request['users_id'] ? $request['users_id'] : [];
        $workshop_id = $request->workshop_id ? $request->workshop_id : null;
        $placement_id = $request->placement_id ? $request->placement_id : null;
        $branch_id = $request->branch_id ? $request->branch_id : null;

        Log::info('$userIds ');
        Log::info($userIds);

        $query = Detail::whereIn('user_id', $userIds);
        $query->update([
            'workshop_id' => $workshop_id,
            'placement_id' => $placement_id,
            'branch_id' => $branch_id
        ]);

        $result = [
            'message' => 'Tetapan woyshop telah disimpan'
        ];

        return $result;
    }

    public function revoke(Request $request){

        $result = 0;

        $userIds = $request['users_id'] ? $request['users_id'] : [];

        $query = Detail::whereIn('user_id', $userIds);
        $queryUser = User::whereIn('id', $userIds);
        $Revoke = RefStatus::where('code', '08')->first();

        $query->update([
            'ref_status_id' => $Revoke->id,
            'updated_by' => Auth::user()->id
        ]);

        $queryUser->update([
            'username' => DB::raw('CONCAT(\'xxx-\', email, \'-\', username)'),
            'email' => DB::raw('CONCAT(\'xxx-\', email)')
        ]);

        $result = [
            'message' => 'Maklumat pengguna telah dibuang'
        ];

        return $result;
    }

    public function resendLinkVerifyUser(Request $request){

        $langEmailSubject = [
            'bm' => 'Pengaktifan Akaun Spakat',
            'en' => 'Spakat Account Activation'
        ];

        $token = sha1(uniqid(time(), true));

        $url = route('activation.user', [
            "token" => $token,
            "view" => 'create'
        ]);

        $userIds = $request['users_id'] ? $request['users_id'] : [];

        foreach ($userIds as $key => $user_id) {

            $user = User::find($user_id);

            $data = [
                'from' => env('MAIL_FROM_NAME'),
                'subject' => $langEmailSubject[$this->lang],
                'title'=> '',
                'body' => 'asdsd',
                'fullname' => $user-> name,
                'url' => $url,
                'lang' => $this->lang,
            ];

            $delPrev = UserVerification::where([
                'user_id' =>  $user->id
            ]);
    
            $delPrev->delete();
    
            UserVerification::create([
                'user_id'=> $user->id,
                'token' => $token,
                'status' => true,
                'expired_token' => Carbon::now()->addDays(3)
            ]);
    
            try {
    
                $mailer = Mail::class;
                $mailer::to($user)->send(new userEmailVerification($data));
    
                Log::info('email send ?');
                Log::info(count($mailer::failures()));
    
                if ($mailer::failures()) {
                    $response = [
                        'status' => 401,
                        'message' => 'Emel tidak berjaya dihantar'
                    ];
                } else {
                    //function hantar email
                    $response = [
                        'status' => 200,
                        'message' => ''
                    ];
                }
    
            } catch(\Swift_TransportException $transportExp){
                Log::info($transportExp);
                $transportExp->getMessage();
              }
        }

        return [
            'status' => 200,
            'message' => 'Pautan verfikasi berjaya dihantar'
        ];

    }

    public function detail(Request $request){
        $roles = RefRole::all();
        $workshops = RefWorkshop::all();
        $branches = RefOwner::whereHas('hasOwnerType', function($q){
            $q->where([
                'status' => 1,
                'display_for' => 'vehicle_register'
            ])->whereIn('code', ['01','02']);
        })->orderByRaw('code=\'0125\' desc, name asc');

        Log::info($branches->toSql());

        $obj = [
            'tab' => $request->tab,
            'roles' => $roles,
            'workshops' => $workshops,
            'branches' => $branches->get()
        ];

        return $obj;
    }

}
