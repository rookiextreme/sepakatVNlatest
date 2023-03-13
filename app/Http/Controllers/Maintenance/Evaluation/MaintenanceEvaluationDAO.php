<?php

namespace App\Http\Controllers\Maintenance\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Mail\module\maintenance\evaluation\SendEmailAppointmentAppNotifyToApplicant;
use App\Mail\module\maintenance\evaluation\SendEmailSubmissionAppNotifyToApplicant;
use App\Mail\module\maintenance\evaluation\SendEmailSubmissionAppNotifyToAssistantEngineer;
use App\Mail\module\maintenance\evaluation\SendEmailSubmissionAppNotifyToEngineer;
use App\Models\Maintenance\MaintenanceApplicationStatus;
use App\Models\Maintenance\MaintenanceEvaluation;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MaintenanceEvaluationDAO extends Controller
{
    public $id = -1;
    public $vehicleDetail;
    public $detail = null;
    public $is_display = 0;
    public $states;
    public $maintenance_type_list;
    public $categoryList;
    public $vehicle;
    public $ref_worksops;

    public function list(Request $request)
    {
        Log::info("sini");
        $AccessMaintenanceEvaluation = auth()->user()->vehicle('03', '02');

        $status_code = $request->status_code ? $request->status_code : 'all_inprogress';
        $maintenance_evaluation_list = new MaintenanceEvaluation();
        $maintenance_evaluation_list = $maintenance_evaluation_list->setTable('maintenance.evaluation AS a')
        ->select('a.id', 'a.ref_number', 'a.applicant_name', 'a.phone_no', 'a.email', 'a.department_name', 'a.app_status_id', 'a.agency_id', 'a.assign_engineer_by', 'a.assistant_engineer_by', 'a.appointment_dt', 'a.created_at')
        ->join('maintenance.application_status as b', 'b.id', 'a.app_status_id');
        Log::info('$status_code => '.$status_code);

        switch ($status_code) {
            case 'all_inprogress':
                $maintenance_evaluation_list->whereIn('b.code', ['02','03','11']);
                break;
                
            case 'my_job':

                $evaluation_status_list = null;

                if(auth()->user()->isAdmin()){
                    $maintenance_evaluation_list->whereIn('b.code', ['02','03','11']);
                }
                else if(auth()->user()->isSeniorEngineerMaintenance()){
                    $evaluation_status_list = '(\'03\')';
                }
                else if(auth()->user()->isEngineerMaintenance()){
                    $evaluation_status_list = '(\'01\',\'08\')';
                }
                else if(auth()->user()->isAssistEngineerMaintenance()){
                    $evaluation_status_list = '(\'01\',\'07\')';
                    $maintenance_evaluation_list->where('assistant_engineer_by', Auth::user()->id);
                } else {
                    $evaluation_status_list = '(\'08\')';
                }

                if($evaluation_status_list){
                    $maintenance_evaluation_list
                    ->whereRaw('EXISTS (
                        SELECT
                            1
                        FROM
                            maintenance.evaluation_vehicle ev
                        JOIN maintenance.vehicle_status vs ON vs.id = ev.maintenance_vehicle_status_id
                        WHERE
                            ev.maintenance_evaluation_id = a.id and vs.code IN '.$evaluation_status_list.' AND b.code IN (\'02\', \'03\', \'11\')  
                        )');
                }

                break;
            case '01':
                $maintenance_evaluation_list->where('b.code', '01');
                break;
            case '02':
                $maintenance_evaluation_list->where('b.code', '02');
                break;
            case '03':
                $maintenance_evaluation_list->where('b.code', '03');
                break;
            case '04':
                $maintenance_evaluation_list->where('b.code', '04');
                break;
            case '11':
                $maintenance_evaluation_list->where('b.code', '11');
                break;
            case '08':
                $maintenance_evaluation_list->where('b.code', '08');
                break;
            case '06':
                $maintenance_evaluation_list->where('b.code', '06');
                break;
        }

        if(auth()->user()->isAdmin()){
            Log::info('saya admin');
        } else if(auth()->user()->isForemenMaintenance()){
            Log::info('saya isForemenMaintenance');
            $maintenance_evaluation_list->where(
                [
                    'a.workshop_id' => auth()->user()->detail->workshop_id,
                    'b.code' => '03'
                ]
            );
        } elseif(auth()->user()->isSeniorEngineerMaintenance()){
            Log::info('saya isSeniorEngineerMaintenance');
            $maintenance_evaluation_list->where(
                [
                    'a.workshop_id' => auth()->user()->detail->workshop_id,
                    'b.code' => '03'
                ]
            );
        }
        elseif(auth()->user()->isEngineerMaintenance()){
            Log::info('saya isEngineerMaintenance');
            $maintenance_evaluation_list->whereRaw('a.workshop_id = '.auth()->user()->detail->workshop_id.' and (a.assign_engineer_by = '.auth()->user()->id.' or a.assign_engineer_by is null)');
        } elseif(auth()->user()->isAssistEngineerMaintenance()){
            Log::info('saya isAssistEngineerMaintenance');
            Log::info('saya workshop '.auth()->user()->detail->workshop_id);
            Log::info('auth()->user()->id '.auth()->user()->id);
            $maintenance_evaluation_list->where(
                [
                    'a.assistant_engineer_by' => auth()->user()->id,
                    'a.workshop_id' => auth()->user()->detail->workshop_id
                ]
            );
            
        } else{
            Log::info('saya orang awam');
            $maintenance_evaluation_list->where('a.created_by', auth()->user()->id);
        }

        if($AccessMaintenanceEvaluation->fleet_has_limit){
            $maintenance_evaluation_list->where(
                [
                    'a.workshop_id' => auth()->user()->detail->workshop_id
                ]
            );
        }

        $maintenance_evaluation_list->whereNotIn('b.code', ['00', '01', '07']);
        $searchQuery = "";

        if($request->search){
            $request->search = strtoupper($request->search);

            switch ($request->filterOpt) {
                case 'flt-refnumber':
                    $searchQuery = "upper(ref_number) LIKE '%".$request->search."%'";
                    $maintenance_evaluation_list->whereRaw($searchQuery);
                    break;
                case 'flt-applicant':
                    $searchQuery = "upper(applicant_name) LIKE '%".$request->search."%'";
                    $maintenance_evaluation_list->whereRaw("upper(applicant_name) LIKE '%".$request->search."%'");
                    break;
                case 'flt-telno':
                    $searchQuery = "upper(phone_no) LIKE '%".$request->search."%'";
                    $maintenance_evaluation_list->whereRaw($searchQuery);
                    break;
                default:
                    $searchQuery = "(upper(ref_number) LIKE '%".$request->search."%' OR upper(applicant_name) LIKE '%".$request->search."%' OR upper(phone_no) LIKE '%".$request->search."%')";
                    $maintenance_evaluation_list->whereRaw($searchQuery);
                    break;
            }
        }

        if($searchQuery){
            $searchQuery = " and ".$searchQuery;
        }

        if($status_code == '01'){
            $maintenance_evaluation_list->whereRaw('(b.code in (\'01\') and a.created_by = '.auth()->user()->id.')');
        } else if ($status_code == 'all_inprogress'){
            $maintenance_evaluation_list->orWhereRaw('(b.code in (\'01\', \'02\', \'03\', \'11\') '.$searchQuery.' and a.created_by = '.auth()->user()->id.' )');
        } else {
            $maintenance_evaluation_list->orWhereRaw('(b.code = \''.$status_code.'\' '.$searchQuery.' and a.created_by = '.auth()->user()->id.' )');
        }

        Log::info(' auth()->user()->isPublic() => '.auth()->user()->isPublic());

        if($request->search){
            if($request->filterOpt == 'flt-all' || $request->filterOpt == 'flt-plateno'){
                $maintenance_evaluation_list->orWhereRaw("EXISTS (
                    SELECT
                        * 
                    FROM
                        maintenance.evaluation_vehicle
                    WHERE
                        maintenance.evaluation_vehicle.maintenance_evaluation_id = a.id 
                        AND upper(maintenance.evaluation_vehicle.plate_no) LIKE '%".strtoupper($request->search)."%'
                    )");
            }
        }

        Log::info($maintenance_evaluation_list->toSql());
        Log::info($maintenance_evaluation_list->getBindings());

        Log::info($maintenance_evaluation_list->toSql());

        if($request->mode == 'count'){
            return $maintenance_evaluation_list->count();
        } else {
            return $maintenance_evaluation_list->paginate(5);
        }

        return $maintenance_evaluation_list->orderBy('a.updated_at', 'desc')->paginate(5);
    }

    public function read(Request $request)
    {
        $id = $request->id ? $request->id : session()->get('mevaluation_current_detail_id');

        $this->detail = MaintenanceEvaluation::find($id);

        if($this->detail){
            session()->put('mevaluation_current_detail_id', $this->detail->id);
        }

        return $this->detail;
    }

    public function upsert(Request $request)
    {
        $request->validate([
            'applicant_name' => 'required',
            'agency_id' => 'required',
            'department_name' => 'required',
            'hod_name' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'state_id' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'applicant_workshop_id' => 'required',
            'app_dates' => 'required|min:0',
        ],[
            'applicant_name.required' => 'Sila isi nama pemohon',
            'agency_id.required' => 'Sila pilih kementerian',
            'department_name.required' => 'Sila isi nama jabatan',
            'hod_name.required' => 'Sila isi nama',
            'address.required' => 'Sila isi alamat',
            'postcode.required' => 'Sila isi podkod',
            'state_id.required' => 'Sila isi nama negeri',
            'phone_no.required' => 'Sila isi no.telefon',
            'email.required' => 'Sila isi emel',
            'applicant_workshop_id.required' => 'Sila pilih bengkel',
            'app_dates.required' => 'Sila isi salah satu temujanji',
        ]);

        $this->id = session()->get('mevaluation_current_detail_id');
        $this->detail = MaintenanceEvaluation::find($this->id);
        $data = [
            'applicant_name' => $request->applicant_name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'state_id' => $request->state_id,
            'department_name' => $request->department_name,
            'hod_name' => $request->hod_name,
            'appointment_dt1' => $request->date_1,
            'appointment_dt2' => $request->date_2,
            'appointment_dt3' => $request->date_3,
            'agency_id' => $request->agency_id,
            'applicant_workshop_id' => $request->applicant_workshop_id,
            'workshop_id' => $request->applicant_workshop_id
        ];

        Log::info($data);

        if($this->detail){
            $data['updated_by'] =  Auth::user()->id;
            if($this->detail->hasStatus->code == '01'){
                $data['ref_number'] = $this->generateRefNumber($data, $request->applicant_workshop_id);
            }
            $query = $this->detail->update($data);
            $this->id = $this->detail->id;
            $this->message = 'Maklumat Berjaya Disimpan';
            $this->url = Route('maintenance.evaluation.register', ['id'=>$this->id, 'tab' => '2']);
        } else {
            $data['created_by'] =  Auth::user()->id;
            $data['ref_number'] = $this->generateRefNumber($data, $request->applicant_workshop_id);
            $data['app_status_id'] = $this->maintenanceStatus("01");
            $query = MaintenanceEvaluation::create($data);
            $this->id = $query->id;
            $this->message = 'Maklumat Berjaya Ditambah';
            $this->url = Route('maintenance.evaluation.register', ['id'=>$this->id, 'tab' => '2']);
        }

        $response = [
            'query' => $query,
            'code' => 200,
            'message' =>  $this->message,
            'url' => $this->url
        ];

        unset($response['query']);
        return $response;
    }

    public function changeWorkshop(Request $request){
        $maintenance_id = $request->maintenance_id ? session()->get('mevaluation_current_detail_id') : session()->get('mevaluation_current_detail_id');
        $query = MaintenanceEvaluation::find($maintenance_id);
        $data = [
            'engineer_workshop_id' => $request->workshop_id,
            'workshop_id' => $request->workshop_id
        ];
        if($query){
            $query->update($data);
        }

        $response = [
            'message' => 'Woksyop berjaya tetapkan'
        ];

        return $response;
    }

    public function assignAssistantEngineer(Request $request){
        $maintenance_id = $request->maintenance_id ? session()->get('mevaluation_current_detail_id') : session()->get('mevaluation_current_detail_id');
        $query = MaintenanceEvaluation::find($maintenance_id);
        $data = [
            'assistant_engineer_by' => $request->assist_engineer_id
        ];
        if($query){
            $query->update($data);
        }

        $this->sendEmailNotificationToAssistEngineer($query);

        $response = [
            'message' => 'Penolong jurutera berjaya tetapkan'
        ];

        return $response;
    }

    public function verify(Request $request){

        $maintenance_id = $request->maintenance_id ? session()->get('mevaluation_current_detail_id') : session()->get('mevaluation_current_detail_id');
        $verify = MaintenanceEvaluation::find($maintenance_id);
        $status_id = $this->maintenanceStatus("02");
        $data = [
            'app_status_id' => $status_id,
        ];

        $response = $verify->update($data);
        $this->sendEmailNotificationToApplicant($verify);
        $this->sendEmailNotificationToEngineer($verify);

        if($response){
            return [
                    'url' => route('maintenance.evaluation.list')
                ];
        }
    }

    public function setAppointment(Request $request)
    {
        $maintenance_id = session()->get('mevaluation_current_detail_id');
        $setAppointment = MaintenanceEvaluation::find($maintenance_id);
        $data = [
            'appointment_dt' => $request->appointment_dt == 'other_appointment_dt' ?  $request->other_appoinment_dt : $request->appointment_dt,
            'is_other_app_dt' => $request->appointment_dt == 'other_appointment_dt' ? true : false
        ];

        $query = $setAppointment->update($data);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat temujanji berjaya dikemaskini',
            'url' => route('maintenance.evaluation.register', [
                'id' => $maintenance_id,
                'tab' => 2
            ])
        ];

        Log::info($response);

        unset($response['query']);

        return $response;
    }

    public function examination(){
        Log::info('/examination');
        $examination = MaintenanceEvaluation::find(session()->get('mevaluation_current_detail_id'));
        $data = [
            'app_status_id' => $this->maintenanceStatus("03")
        ];
        $examination->update($data);
        $this->sendEmailAppointmentNotificationToApplicant($examination);
        return [
            'url' => route('maintenance.evaluation.list')
        ];
    }

    public function verification(){
        $examination = MaintenanceEvaluation::find(session()->get('mevaluation_current_detail_id'));
        $data = [
            'app_status_id' => $this->maintenanceStatus("04")
        ];
        $examination->update($data);
        return [
            'url' => route('maintenance.evaluation.list')
        ];
    }

    public function approval(){
        $examination = MaintenanceEvaluation::find(session()->get('mevaluation_current_detail_id'));
        $data = [
            'app_status_id' => $this->maintenanceStatus("05")
        ];
        $examination->update($data);

        $this->sendEmailNotificationToApplicant($examination);

        return [
            'url' => route('maintenance.evaluation.list')
        ];
    }

    private function generateRefNumber($data, $workshop_id){
        $year = Carbon::now()->format('Y');
        $query = MaintenanceEvaluation::orderBy('created_at', 'desc');
        if($query->first()){
            $baseYear = Carbon::parse($query->first()->created_at)->format('Y');
        } else {
            $baseYear = Carbon::now()->format('Y');
        }

        $modulePrefix = 'S'; //Module Senggara
        $SubModulePrefix = 'P'; //Pemeriksaan

        $diffYear = $year-$baseYear;
        $HelpersFunction = new HelpersFunction();
        $alpha = $HelpersFunction->getAlpha($diffYear);

        $workShop = RefWorkshop::find($workshop_id);
        $lastSeq = 0;
        if($query->first()){
            $lastSeq = substr($query->first()->ref_number, -4);
        }
        $applicationRunningNo = str_pad(((int)$lastSeq +1), 4, '0', STR_PAD_LEFT);

        return $modulePrefix.$SubModulePrefix.$alpha.$workShop->code.$applicationRunningNo;
    }

    private function sendEmailAppointmentNotificationToApplicant($detail){
        $emailBody = [
            'title' => 'Maklumat Temujanji Kenderaan',
            'subject' => 'Maklumat Temujanji Kenderaan '.Carbon::now()->format('d/m/Y'),
            'detail' => $detail,
        ];

        $userEmail = [];
        array_push($userEmail, $detail->email);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailAppointmentAppNotifyToApplicant($emailBody));
    }

    private function sendEmailNotificationToAssistEngineer($detail){
        $emailBody = [
            'title' => 'Maklumat Pemeriksaan Kenderaan',
            'subject' => 'Maklumat Pemeriksaan Kenderaan '.Carbon::now()->format('d/m/Y'),
            'detail' => $detail
        ];

        $userEmail = [];
        array_push($userEmail, $detail->hasAssistantEngineerBy->email);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailSubmissionAppNotifyToAssistantEngineer($emailBody));
    }

    private function getEngineer(){
        $filter_by_roles = array('03','11','08');
        $users = User::select(
            'users.users.id AS id',
            'users.users.name AS name',
            'users.users.email AS email'
        );
        $users->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.users.id');
        $users->join('ref_role', 'ref_role.id', '=', 'model_has_roles.role_id');
        $users->whereIn('ref_role.code', $filter_by_roles);
        return $users->get();
    }

    private function sendEmailNotificationToApplicant($verify){
        $emailBody = [
            'title' => 'Maklumat Pemeriksaan Kenderaan',
            'subject' => 'Maklumat Pemeriksaan Kenderaan '.Carbon::now()->format('d/m/Y'),
            'detail' => $verify,
        ];

        $userEmail = [];
        array_push($userEmail, $verify->email);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailSubmissionAppNotifyToApplicant($emailBody));
    }

    private function sendEmailNotificationToEngineer($verify){
        $emailBody = [
            'title' => 'Maklumat Pemeriksaan Kenderaan',
            'subject' => 'Maklumat Pemeriksaan Kenderaan '.Carbon::now()->format('d/m/Y'),
            'detail' => $verify,
        ];

        $userEmail = [];

        $userApproval = new User();

        $userApprovalList = $userApproval->hasManyApprovalByModuleFilterWorkshop('03','01', $verify->hasWorkShop->id);
        foreach ($userApprovalList as $userApproval) {
            foreach ($userApproval->hasManyRoles as $roles) {
                array_push($userEmail, $roles->hasUser->email);
            }
        }

        Log::info($userEmail);
        Log::info($emailBody);

        //Mail::to($userEmail)->send(new SendEmailSubmissionAppNotifyToEngineer($emailBody));
    }

    public function approve(){
        $examination = MaintenanceEvaluation::find(session()->get('mevaluation_current_detail_id'));
        $data = [
            'app_status_id' => $this->maintenanceStatus("08")
        ];
        $examination->update($data);
        Log::info($examination->hasActiveApprovedVehicle->count());
        foreach ($examination->hasActiveApprovedVehicle as $hasActiveApprovedVehicle) {
            $hasActiveApprovedVehicle->update([
                'cert_hash_key' => Str::random(40)
            ]);
        }

        $this->sendEmailNotification($examination);

        return [
            'url' => route('maintenance.evaluation.list')
        ];
    }

    public function maintenanceStatus($code)
    {
        $status = MaintenanceApplicationStatus::where('code',$code)->first();
        return $status->id;
    }

    public function delete(Request $request){
        $ids = $request->ids;

        $query = MaintenanceEvaluation::whereIn('id', $ids);
        $query->update([
            'app_status_id' => $this->maintenanceStatus('00')
        ]);

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

    }

    public function cancel(Request $request){
        $ids = $request->ids;

        $query = MaintenanceEvaluation::whereIn('id', $ids);
        $query->update([
            'app_status_id' => $this->maintenanceStatus('06')
        ]);

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dibatalkan'
        ];

    }

}
