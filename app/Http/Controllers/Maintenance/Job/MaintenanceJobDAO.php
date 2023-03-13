<?php

namespace App\Http\Controllers\Maintenance\Job;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Mail\module\maintenance\job\SendEmailAppointmentAppNotifyToApplicant;
use App\Mail\module\maintenance\job\SendEmailSubmissionAppNotifyToApplicant;
use App\Mail\module\maintenance\job\SendEmailSubmissionAppNotifyToAssistantEngineer;
use App\Mail\module\maintenance\job\SendEmailSubmissionAppNotifyToEngineer;
use App\Mail\module\maintenance\job\SendEmailSubmissionAppVehicleNotifyToApplicant;
use App\Models\Fleet\FleetDepartment;
use App\Models\Maintenance\MaintenanceApplicationStatus;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\Maintenance\MaintenanceJobVehicle;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormRepair;
use App\Models\RefWorkshop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MaintenanceJobDAO extends Controller
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
        $AccessMaintenanceJob = auth()->user()->vehicle('03', '02');

        $status_code = $request->status_code ? $request->status_code : 'all_inprogress';
        $maintenance_job_list = new MaintenanceJob();
        $maintenance_job_list = $maintenance_job_list->setTable('maintenance.job AS a')
        ->select('a.id', 'a.ref_number', 'a.applicant_name', 'a.phone_no', 'a.email', 'a.department_name', 'a.app_status_id', 'a.agency_id', 'a.assign_engineer_by', 'a.assistant_engineer_by', 'a.assistant_engineer_repair_by', 'a.assistant_engineer_service_by', 'a.appointment_dt', 'a.created_at')
        ->join('maintenance.application_status as b', 'b.id', 'a.app_status_id');

        Log::info('$status_code => '.$status_code);

        switch ($status_code) {
            case 'all_inprogress':
                $maintenance_job_list->whereIn('b.code', ['02','03','11']);
                break;
            case 'my_job':

                $job_status_list = null;
                $queryInternalStatus = "";
                $queryExternalStatus = "";

                if(auth()->user()->isAdmin()){
                    $maintenance_job_list->whereIn('b.code', ['02','03','11']);
                }
                else if(auth()->user()->isSeniorEngineerMaintenance()){
                    $job_status_list = '(\'10\')';
                }
                else if(auth()->user()->isEngineerMaintenance()){
                    $job_status_list = '(\'01\',\'06\',\'09\')';
                }
                else if(auth()->user()->isAssistEngineerMaintenance()){
                    $job_status_list = '(\'01\',\'03\',\'08\')';
                    $maintenance_job_list->where('assistant_engineer_by', Auth::user()->id);
                    $queryInternalStatus = ' and (jvs.code = \'11\' and jvms_internal.code IN (\'02\') and b.code = \'03\')';
                    $queryExternalStatus = ' and (jvs.code = \'11\' and jvms_external.code IN (\'05\') and b.code = \'03\')';
                } else {
                    $job_status_list = '(\'08\')';
                }

                if($job_status_list){
                    $maintenance_job_list
                    ->whereRaw('EXISTS (
                        SELECT
                            1
                        FROM
                            maintenance.job_vehicle jv
                        LEFT JOIN maintenance.job_vehicle_examination_form jve ON jve.vehicle_id = jv.id
                        JOIN maintenance.job_vehicle_status jvs ON jvs.id = jve.job_vehicle_status_id
                        WHERE
                            jv.maintenance_job_id = a.id and jvs.code IN '.$job_status_list.' AND b.code IN (\'02\', \'03\')
                        )');

                    if(auth()->user()->isAssistEngineerMaintenance()){
                        $maintenance_job_list->orWhereRaw('EXISTS (
                            SELECT
                                1
                            FROM
                                maintenance.job_vehicle jv
                            JOIN maintenance.job_vehicle_examination_form jve ON jve.vehicle_id = jv.id
                            JOIN maintenance.job_vehicle_status jvs ON jvs.id = jve.job_vehicle_status_id
                            JOIN maintenance.job_vehicle_maintenance_status jvms_internal ON jvms_internal.id = jve.internal_repair_status_id
                            WHERE
                                jv.maintenance_job_id = a.id '.$queryInternalStatus.'
                            )')->whereNotIn('b.code', ['00', '01', '07'])->where([
                                'a.assistant_engineer_by' => auth()->user()->id,
                                'a.workshop_id' => auth()->user()->detail->workshop_id
                            ])
                        ->orWhereRaw('EXISTS (
                            SELECT
                                1
                            FROM
                                maintenance.job_vehicle jv
                            JOIN maintenance.job_vehicle_examination_form jve ON jve.vehicle_id = jv.id
                            JOIN maintenance.job_vehicle_status jvs ON jvs.id = jve.job_vehicle_status_id
                            JOIN maintenance.job_vehicle_maintenance_status jvms_external ON jvms_external.id = jve.ext_repair_status_id
                            WHERE
                                jv.maintenance_job_id = a.id '.$queryExternalStatus.'
                            )')->whereNotIn('b.code', ['00', '01', '07'])
                            ->where([
                                'a.assistant_engineer_by' => auth()->user()->id,
                                'a.workshop_id' => auth()->user()->detail->workshop_id
                            ]);
                    }
                }

                break;
            case '01':
                $maintenance_job_list->where('b.code', '01');
                break;
            case '02':
                $maintenance_job_list->where('b.code', '02');
                break;
            case '03':
                $maintenance_job_list->where('b.code', '03');
                break;
            case '04':
                $maintenance_job_list->where('b.code', '04');
                break;
            case '11':
                $maintenance_job_list->where('b.code', '11');
                break;
            case '08':
                $maintenance_job_list->where('b.code', '08');
                break;
            case '06':
                $maintenance_job_list->where('b.code', '06');
                break;
            case '09':
                // Pengesahan Kajian Pasaran
                $maintenance_job_list->whereRaw('EXISTS (
                    SELECT
                        1
                    FROM
                        maintenance.job_vehicle jv
                    JOIN maintenance.job_vehicle_examination_form jve ON jve.vehicle_id = jv.id
                    JOIN maintenance.job_vehicle_status jvs ON jvs.id = jve.job_vehicle_status_id
                    WHERE
                        jv.maintenance_job_id = a.id and jvs.code = \'06\'
                    )');
                break;
            case '10':
                // Pengesahan Jadual Harga
                $maintenance_job_list->whereRaw('EXISTS (
                    SELECT
                        1
                    FROM
                        maintenance.job_vehicle jv
                    JOIN maintenance.job_vehicle_examination_form jve ON jve.vehicle_id = jv.id
                    JOIN maintenance.job_vehicle_status jvs ON jvs.id = jve.job_vehicle_status_id
                    WHERE
                        jv.maintenance_job_id = a.id and jvs.code = \'10\'
                    )');
                break;
                case '12':
                    // Semakan Jadual Harga
                    $maintenance_job_list->whereRaw('EXISTS (
                        SELECT
                            1
                        FROM
                            maintenance.job_vehicle jv
                        JOIN maintenance.job_vehicle_examination_form jve ON jve.vehicle_id = jv.id
                        JOIN maintenance.job_vehicle_status jvs ON jvs.id = jve.job_vehicle_status_id
                        WHERE
                            jv.maintenance_job_id = a.id and jvs.code = \'09\'
                        )');
                    break;
        }

        if(auth()->user()->isAdmin()){
            Log::info('saya admin');
        } elseif(auth()->user()->isForemenMaintenance()){
            Log::info('saya isForemenMaintenance');
            $maintenance_job_list->where(
                [
                    'a.workshop_id' => auth()->user()->detail->workshop_id,
                    'b.code' => '03'
                ]
            );
        } elseif(auth()->user()->isSeniorEngineerMaintenance()){
            Log::info('saya isSeniorEngineerMaintenance');
            $maintenance_job_list->where(
                [
                    'a.workshop_id' => auth()->user()->detail->workshop_id,
                    'b.code' => '03'
                ]
            );
        }
        elseif(auth()->user()->isEngineerMaintenance()){
            Log::info('saya isEngineerMaintenance');
            $maintenance_job_list->whereRaw('a.workshop_id = '.auth()->user()->detail->workshop_id.' and (a.assign_engineer_by = '.auth()->user()->id.' or a.assign_engineer_by is null)');

        } elseif(auth()->user()->isAssistEngineerMaintenance()){
            Log::info('saya isAssistEngineerMaintenance');
            Log::info('saya workshop '.auth()->user()->detail->workshop_id);
            Log::info('auth()->user()->id '.auth()->user()->id);
            $maintenance_job_list->where(
                [
                    'a.assistant_engineer_by' => auth()->user()->id,
                    'a.workshop_id' => auth()->user()->detail->workshop_id
                ]
            );


        } else {
            Log::info('saya orang awam');
            Log::info(auth()->user()->id);
            $maintenance_job_list->where('a.created_by', auth()->user()->id);
        }

        if($AccessMaintenanceJob->fleet_has_limit){
            $maintenance_job_list->where(
                [
                    'a.workshop_id' => auth()->user()->detail->workshop_id
                ]
            );
        }

        $maintenance_job_list->whereNotIn('b.code', ['00', '01', '07']);
        $searchQuery = "";

        if($request->search){
            $request->search = strtoupper($request->search);

            switch ($request->filterOpt) {
                case 'flt-refnumber':
                    $searchQuery = "upper(ref_number) LIKE '%".$request->search."%'";
                    $maintenance_job_list->whereRaw($searchQuery);
                    break;
                case 'flt-applicant':
                    $searchQuery = "upper(applicant_name) LIKE '%".$request->search."%'";
                    $maintenance_job_list->whereRaw("upper(applicant_name) LIKE '%".$request->search."%'");
                    break;
                case 'flt-telno':
                    $searchQuery = "upper(phone_no) LIKE '%".$request->search."%'";
                    $maintenance_job_list->whereRaw($searchQuery);
                    break;
                default:
                    $searchQuery = "(upper(ref_number) LIKE '%".$request->search."%' OR upper(applicant_name) LIKE '%".$request->search."%' OR upper(phone_no) LIKE '%".$request->search."%')";
                    $maintenance_job_list->whereRaw($searchQuery." OR EXISTS (
                        SELECT
                            *
                        FROM
                            maintenance.job_vehicle
                        WHERE
                            maintenance.job_vehicle.maintenance_job_id = a.id
                            AND upper(maintenance.job_vehicle.plate_no) LIKE '%".strtoupper($request->search)."%'
                        )");
                    break;
            }
        }

        if($searchQuery){
            $searchQuery = " and ".$searchQuery;
        }

        if($status_code == '01'){
            $maintenance_job_list->orWhereRaw('(b.code in (\'01\') and a.created_by = '.auth()->user()->id.')');
        } else if ($status_code == 'all_inprogress'){
            $maintenance_job_list->orWhereRaw('(b.code in (\'01\', \'02\', \'03\', \'11\') '.$searchQuery.' and a.created_by = '.auth()->user()->id.' )');
        } else if ($status_code == 'my_job'){
            $maintenance_job_list->orWhereRaw('(b.code in (\'01\') '.$searchQuery.' and a.created_by = '.auth()->user()->id.' )');
        } else {
            $maintenance_job_list->orWhereRaw('(b.code = \''.$status_code.'\''.$searchQuery.' and a.created_by = '.auth()->user()->id.' )');
        }

        if($request->search){
            if($request->filterOpt == 'flt-all' || $request->filterOpt == 'flt-plateno'){
                $maintenance_job_list->orWhereRaw("EXISTS (
                    SELECT
                        *
                    FROM
                        maintenance.job_vehicle
                    WHERE
                        maintenance.job_vehicle.maintenance_job_id = a.id
                        AND upper(maintenance.job_vehicle.plate_no) LIKE '%".strtoupper($request->search)."%'
                    )");
            }
        }

        if(auth()->user()->isEngineerMaintenance()){
            $maintenance_job_list->orderByRaw('CASE WHEN (a.assistant_engineer_by IS NULL and b.code = \'02\' ) THEN 0 ELSE 1 END asc, a.updated_at desc');
        } else {
            $maintenance_job_list->orderBy('a.updated_at', 'desc');
        }

        Log::info($maintenance_job_list->toSql());

        if($request->mode == 'count'){
            return $maintenance_job_list->count();
        } else {
            return $maintenance_job_list->paginate(5);
        }
    }

    public function read(Request $request)
    {
        $id = $request->id ? $request->id : session()->get('mjob_current_detail_id');

        $this->detail = MaintenanceJob::find($id);

        if($this->detail){
            session()->put('mjob_current_detail_id', $this->detail->id);
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

        $this->id = session()->get('mjob_current_detail_id');
        $this->detail = MaintenanceJob::find($this->id);
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

        if($this->detail){
            $data['updated_by'] =  Auth::user()->id;
            if($this->detail->hasStatus->code == '01'){
                if($request->applicant_workshop_id !== $this->detail->applicant_workshop_id){
                    $data['ref_number'] = $this->generateRefNumber($data, $request->applicant_workshop_id);
                }
            }
            $query = $this->detail->update($data);
            $this->id = $this->detail->id;
            $this->message = 'Maklumat Berjaya Disimpan';
            $this->url = Route('maintenance.job.register', ['id'=>$this->id, 'tab' => '2']);
        } else {
            $data['created_by'] =  Auth::user()->id;
            $data['ref_number'] = $this->generateRefNumber($data, $request->applicant_workshop_id);
            $data['app_status_id'] = $this->maintenanceStatus("01");
            $query = MaintenanceJob::create($data);
            $this->id = $query->id;
            $this->message = 'Maklumat Berjaya Ditambah';
            $this->url = Route('maintenance.job.register', ['id'=>$this->id, 'tab' => '2']);
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
        $maintenance_id = $request->maintenance_id ? session()->get('mjob_current_detail_id') : session()->get('mjob_current_detail_id');
        $query = MaintenanceJob::find($maintenance_id);
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

        $hasErrors = [];

        if($request->is_repair_required == 1 && !$request->assist_engineer_repair_id){
            $hasErrors['assist_engineer_repair_id'] = ['Sila pilih penolong jurutera (Pembaikan)'];
        }

        if($request->is_service_required == 1 && !$request->assist_engineer_service_id){
            $hasErrors['assist_engineer_service_id'] = ['Sila pilih penolong jurutera (Servis)'];
        }

        if(count($hasErrors)>0){
            return response()->json(['success' => false, 'errors' => $hasErrors], 422);
        }

        $maintenance_id = $request->maintenance_id ? session()->get('mjob_current_detail_id') : session()->get('mjob_current_detail_id');
        $query = MaintenanceJob::find($maintenance_id);
        $data = [
            'assign_engineer_by' => auth()->user()->id,
            'assistant_engineer_repair_by' => $request->assist_engineer_repair_id,
            'assistant_engineer_service_by' => $request->assist_engineer_service_id
        ];

        if($request->is_repair_required == 1 && $request->is_service_required == 0){
            $data['assistant_engineer_by'] = $request->assist_engineer_repair_id;
        }

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

        $maintenance_id = $request->maintenance_id ? session()->get('mjob_current_detail_id') : session()->get('mjob_current_detail_id');
        $verify = MaintenanceJob::find($maintenance_id);
        $status_id = $this->maintenanceStatus("02");
        $data = [
            'app_status_id' => $status_id,
        ];

        $verify->update($data);
        $this->sendEmailNotificationToApplicant($verify);
        $this->sendEmailNotificationToEngineer($verify);

        return [
            'url' => route('maintenance.job.list')
        ];
    }

    public function setAppointment(Request $request)
    {
        $maintenance_id = session()->get('mjob_current_detail_id');
        $setAppointment = MaintenanceJob::find($maintenance_id);
        $data = [
            'assistant_engineer_by' => Auth::user()->id,
            'appointment_dt' => $request->appointment_dt == 'other_appointment_dt' ?  $request->other_appoinment_dt : $request->appointment_dt,
            'is_other_app_dt' => $request->appointment_dt == 'other_appointment_dt' ? true : false
        ];

        $query = $setAppointment->update($data);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat temujanji berjaya dikemaskini',
            'url' => route('maintenance.job.register', [
                'id' => $maintenance_id,
                'tab' => 2
            ])
        ];

        Log::info($response);

        unset($response['query']);

        return $response;
    }

    public function examination(){
        $examination = MaintenanceJob::find(session()->get('mjob_current_detail_id'));
        $data = [
            'app_status_id' => $this->maintenanceStatus("03")
        ];
        $examination->update($data);
        $this->sendEmailAppointmentNotificationToApplicant($examination);

        return [
            'url' => route('maintenance.job.list')
        ];
    }

    public function verification(){
        $examination = MaintenanceJob::find(session()->get('mjob_current_detail_id'));
        $data = [
            'app_status_id' => $this->maintenanceStatus("04")
        ];

        $examination->update($data);
        return [
            'url' => route('maintenance.job.list')
        ];
    }

    public function approval(){
        $examination = MaintenanceJob::find(session()->get('mjob_current_detail_id'));
        $data = [
            'app_status_id' => $this->maintenanceStatus("05")
        ];
        $examination->update($data);

        $this->sendEmailNotification($examination);

        return [
            'url' => route('maintenance.job.list')
        ];
    }

    public function generateRefNumber($data, $workshop_id){
        $year = Carbon::now()->format('Y');
        $query = MaintenanceJob::orderBy('created_at', 'desc')->whereHas('hasStatus', function($q){
            $q->whereNotIn('code', ['00','06']);
        });
        if($query->first()){
            $baseYear = Carbon::parse($query->first()->created_at)->format('Y');
        } else {
            $baseYear = Carbon::now()->format('Y');
        }

        $modulePrefix = 'S'; //Module Senggaran
        $SubModulePrefix = 'S'; //Servis

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

    public function sendEmailNotification($examination){
        $emailBody = [
            'title' => 'Maklumat Servis/Kerosakan Kenderaan',
            'subject' => 'Maklumat Servis/Kerosakan Kenderaan '.Carbon::now()->format('d/m/Y'),
            'maintenance_job_vehicle_list' => $examination->hasVehicle,
        ];

        $userEmail = [];
        array_push($userEmail, $examination->email);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailSubmissionAppVehicleNotifyToApplicant($emailBody));
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
            'title' => 'Maklumat Servis/Kerosakan Kenderaan',
            'subject' => 'Maklumat Servis/Kerosakan Kenderaan '.Carbon::now()->format('d/m/Y'),
            'detail' => $detail
        ];

        $userEmail = [];
        if($detail->hasAssistantEngineerRepairBy){
            array_push($userEmail, $detail->hasAssistantEngineerRepairBy->email);
        }
        if($detail->hasAssistantEngineerServiceBy){
            array_push($userEmail, $detail->hasAssistantEngineerServiceBy->email);
        }

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailSubmissionAppNotifyToAssistantEngineer($emailBody));
    }

    private function getEngineer(){
        $filter_by_roles = array('03','11');
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
            'title' => 'Maklumat Servis/Kerosakan Kenderaan',
            'subject' => 'Maklumat Servis/Kerosakan Kenderaan '.Carbon::now()->format('d/m/Y'),
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
            'title' => 'Maklumat Servis/Kerosakan Kenderaan',
            'subject' => 'Maklumat Servis/Kerosakan Kenderaan '.Carbon::now()->format('d/m/Y'),
            'detail' => $verify,
        ];

        $userEmail = [];

        $userApproval = new User();

        $userApprovalList = $userApproval->hasManyApprovalByModuleFilterWorkshop('03','02', $verify->hasWorkShop->id);
        foreach ($userApprovalList as $userApproval) {
            foreach ($userApproval->hasManyRoles as $roles) {
                array_push($userEmail, $roles->hasUser->email);
            }
        }

        Log::info($userEmail);
        Log::info($emailBody);
        //TODO setting by profile receive email notification
        //Mail::to($userEmail)->send(new SendEmailSubmissionAppNotifyToEngineer($emailBody));
    }

    public function approve(){
        $examination = MaintenanceJob::find(session()->get('mjob_current_detail_id'));
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
            'url' => route('maintenance.job.list')
        ];
    }

    public function maintenanceStatus($code)
    {
        $status = MaintenanceApplicationStatus::where('code',$code)->first();
        return $status->id;
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    public function completeMaintenance(Request $request){
        $data = [
            'lo_no' => $request->lo_no,
            'completed_dt' => $request->completed_dt ? $this->convertDateToSQLDateTime($request->completed_dt, 'Y-m-d') : null,
            'completed_by' => Auth::user()->id
        ];

        $query = MaintenanceJobVehicle::find($request->vehicle_id);
        $formRepair = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);

        if($request->save_as == 'advance_complete'){

            $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();

            if($formRepair){

                $data['advance'] = 0;
                $data['expense'] = $formRepair->advance != 0 ? $formRepair->advance : $formRepair->expense;

                $formRepair->update($data);
                if($formRepair->hasWaranType){
                    Log::info('completeMaintenance -> updateWarrantFormRepair');
                    $MaintenanceJobVehicleDAO->updateWarrantFormRepair($formRepair, true);
                }
            } else {

                $data['advance'] = 0;
                $data['expense'] = $query->hasExamform->advance != 0 ? $query->hasExamform->advance : $query->hasExamform->expense;
                $query->hasExamform->update($data);

                if($query->hasExamform->hasWaranType){
                    $MaintenanceJobVehicleDAO->updateWarrant($query->hasExamform);
                }
            }

            $checkExistVehicle = FleetDepartment::where('no_pendaftaran', $query->plate_no)->first();

            if($checkExistVehicle){
                $checkExistVehicle->update(
                    [
                        'is_maintenanance' => false
                    ]
                );
            }

        }

        $params = ['search' => $query->plate_no, 'vehicle_id' => $query->id];

        if($request->jve_form_repair_id){
            $params['jve_form_repair_id'] = $request->jve_form_repair_id;
        }

        return [
            'url' => route('maintenance.job.vehicle.monitoring.done.form', $params)
        ];

    }

    public function delete(Request $request){
        $ids = $request->ids;

        $query = MaintenanceJob::whereIn('id', $ids);
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

        $query = MaintenanceJob::whereIn('id', $ids);
        $query->update([
            'app_status_id' => $this->maintenanceStatus('06')
        ]);

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dibatalkan'
        ];

    }

}
