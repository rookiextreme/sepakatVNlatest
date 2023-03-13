<?php

namespace App\Http\Controllers\Assessment\New;

use App\Http\Controllers\Helpers\HelpersFunction;
use App\Mail\module\assessment\new\SendEmailToUserAssessmentNewVehicleStatus;
use App\Mail\module\assessment\new\SendEmailToUserAssessmentNewVehicleStatusExam;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentBpkNo;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentVehicleStatus;
use App\Models\RefWorkshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ValidatedInput;
use Illuminate\Support\Str;

class AssessmentNewDAO
{

    public $id = -1;
    public $detail;
    public $detailVehicle;
    public $message;
    public $url;
    public $statusCode;

    public function list(Request $request)
    {

        $TaskFlowAssessmentNew = auth()->user()->vehicle('02', '01');
        $TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');

        Log::info('AssessmentNewDAO :: list');

        $query = AssessmentNew::orderBy('created_at', 'desc');
        $this->statusCode = $request->status_code ?: 'all_inprogress';

        if($this->statusCode == 'all_inprogress'){
            $query->whereHas('hasStatus', function($q){
                $q->whereNotIn('code', ['00','01', '06','08']);
            });
        } elseif($this->statusCode == 'my_job'){
            if(auth()->user()->isAdmin()){
                $query->whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['03','04', '06']);
                });
            }
            else if(auth()->user()->isEngineerAssessment()){
                $query->whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['05']);
                });
            }
            else if(auth()->user()->isAssistEngineerAssessment()){
                $query->whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['02', '04']);
                });
            }
            else {
                $query->whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['01', '08']);
                });
            }
        
        } elseif($this->statusCode) {
            $query->whereHas('hasStatus', function($q){
                $q->where('code', $this->statusCode);

                if($this->statusCode == '01'){
                    $q->whereNotIn('code', ['01']);
                }
            });
        }

        if(auth()->user()->isAdmin()){
            $query->whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','06','08']);
            });
        }
        elseif (auth()->user()->isEngineer() || auth()->user()->isEngineerAssessment()){
            $query->where('workshop_id', auth()->user()->detail->workshop_id);
            if(!$this->statusCode){
                $query->whereHas('hasStatus',function($q){
                    $q->whereNotIn('code', ['00','06']);
                });
            }
        }

        elseif(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerAssessment()){
            $query->where('workshop_id', auth()->user()->detail->workshop_id);
            if(!$this->statusCode){
                $query->whereHas('hasStatus',function($q){
                    $q->whereNotIn('code', ['00','06']);
                });
            }
        }

        elseif(auth()->user()->isForemenAssessment()){
            $query->where('workshop_id', auth()->user()->detail->workshop_id);
            $query->whereHas('hasStatus', function($q){
                $q->where('code', '03');
            });
        }

        else {
            $query->where('created_by', Auth::user()->id);
            if(!$this->statusCode){
                $query->whereHas('hasStatus',function($q){
                    $q->whereNotIn('code', ['00', '06']);
                });
            }
        }

        if($TaskFlowAssessmentNew->fleet_has_limit){
            $query->where('workshop_id', auth()->user()->detail->workshop_id);
        }

        if($request->search){
            // $query->whereRaw("upper(applicant_name) LIKE '%".strtoupper($request->search)."%' ");
            $query->whereRaw("
            (upper(ref_number) LIKE '%".strtoupper($request->search)."%'
            OR EXISTS (
                SELECT
                    *
                FROM
                    assessment.assessment_new_vehicle
                WHERE
                    assessment.assessment_new_vehicle.assessment_new_id = assessment.assessment_new.id
                    AND upper(assessment.assessment_new_vehicle.plate_no) LIKE '%".strtoupper($request->search)."%'
                )
            )");
        };

        $query->orWhereHas('hasStatus',function($q){
            if($this->statusCode == 'all_inprogress'){
                $q->whereNotIn('code', ['00','06','08']);
            } elseif($this->statusCode) {
                $q->where('code', $this->statusCode);
            }

        })->where('created_by', auth()->user()->id);

        if($request->search){
            $query->whereRaw("
            (upper(ref_number) LIKE '%".strtoupper($request->search)."%'
            OR EXISTS (
                SELECT
                    *
                FROM
                    assessment.assessment_new_vehicle
                WHERE
                    assessment.assessment_new_vehicle.assessment_new_id = assessment.assessment_new.id
                    AND upper(assessment.assessment_new_vehicle.plate_no) LIKE '%".strtoupper($request->search)."%'
                )
            )");
        }

        if($request->mode == 'count'){
            return $query->count();
        } else {
            return $query->paginate(5);
        }
        Log::info($query->toSql());

        return $query->paginate(5);
    }

    public function read(Request $request)

    {

        $id = $request->id ? $request->id : session()->get('new_current_detail_id');

        if($request->id){
            $this->detail = AssessmentNew::find($id);
        }

        Log::info('data'. $this->detail);
        if($this->detail){
            session()->put('new_current_detail_id', $this->detail->id);
        }

        return $this->detail;
    }

    private function generateRefNumber($data, $workshop_id){
        $year = Carbon::now()->format('Y');
        $query = AssessmentNew::orderBy('created_at', 'desc');
        $query->where('is_migrate', false);
        if($query->first()){
            $baseYear = Carbon::parse($query->first()->created_at)->format('Y');
        } else {
            $baseYear = Carbon::now()->format('Y');
        }

        $modulePrefix = 'N'; //Module Penilaian
        $SubModulePrefix = 'B'; //Kenderaan Baharu

        $diffYear = $year-$baseYear;
        $HelpersFunction = new HelpersFunction();
        $alpha = $HelpersFunction->getAlpha($diffYear);

        $workShop = RefWorkshop::find($workshop_id);
        $lastSeq = 0;
        if($query->first()){
            $lastSeq = substr($query->first()->ref_number, -4);
        }
        $applicationRunningNo = str_pad(((int)$lastSeq +1), 4, '0', STR_PAD_LEFT);

        return $modulePrefix.$SubModulePrefix.$alpha.$workShop->ref_code.$applicationRunningNo;
    }

    public function upsert(Request $request)
    {
        $request->validate([
            'applicant_name' => 'required',
            'agency_id' => 'required',
            'department_name' => 'required',
            'ic_no' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'state_id' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'workshop_id' => 'required',
            'hod_title' => 'required',
        ],[
            'applicant_name.required' => 'Sila isikan Nama Pemohon',
            'agency_id.required' => 'Sila pilih Kementerian',
            'department_name.required' => 'Sila isikan Nama Jabatan',
            'ic_no.required' => 'Sila isikan No Kad Pengenalan',
            'address.required' => 'Sila isikan Alamat',
            'postcode.required' => 'Sila isikan Poskod',
            'state_id.required' => 'Sila isikan Nama Negeri',
            'phone_no.required' => 'Sila isikan No Telefon',
            'email.required' => 'Sila isikan Emel',
            'workshop_id.required' => 'Sila pilih Woksyop',
            'hod_title.required' => 'Sila isi Ketua Jabatan (Gelaran)',
        ]);
        // $validator = Validator::make($request->all(), [
        // ],[
        // ]);
        // if ($request->fails()) {
        //     return response()->json(['success' => false, 'errors' => $request->errors()], 422);
        // }

        Log::info('new_current_detail_id => '.session()->get('new_current_detail_id'));

        $this->id = session()->get('new_current_detail_id');

            if($request->id){
                $this->detail = AssessmentNew::find($this->id);
            }

        $data = [
            'applicant_name' => $request->applicant_name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'ic_no' => $request->ic_no,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'state_id' => $request->state_id,
            'department_name' => $request->department_name,
            'appointment_dt1' => $request->appointment_date_1,
            'appointment_dt2' => $request->appointment_date_2,
            'appointment_dt3' => $request->appointment_date_3,
            'agency_id' => $request->agency_id,
            'workshop_id' => $request->workshop_id,
            'hod_title' => $request->hod_title,
        ];

        if($this->detail){
            $data['updated_by'] =  Auth::user()->id;
            if($this->detail->hasStatus->code == '01'){
                $data['ref_number'] = $this->generateRefNumber($data, $request->workshop_id);
            }
            $query = $this->detail->update($data);
            $this->id = $this->detail->id;
            $this->message = 'Maklumat Berjaya Disimpan';
            $this->url = Route('assessment.new.register', ['id' => $this->id, 'tab' => '2']);
        } else {
            $data['created_by'] =  Auth::user()->id;
            $data['ref_number'] = $this->generateRefNumber($data,$request->workshop_id);
            $data['app_status_id'] = $this->assessmentStatus("01");
            $query = AssessmentNew::create($data);
            $this->id = $query->id;
            $this->message = 'Maklumat Berjaya Ditambah';
            $this->url = Route('assessment.new.register', ['id' => $this->id, 'tab' => '2']);
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

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = AssessmentNew::whereIn('id', $ids);
        $query->update([
            'app_status_id' => $this->assessmentStatus('00')
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

    public function cancel(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = AssessmentNew::whereIn('id', $ids);
        $query->update([
            'app_status_id' => $this->assessmentStatus('06')
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dibatalkan'
        ];

        Log::info($response);
        return $response;
    }

    public function verify(Request $request){

        $assessment_id = $request->assessment_id ? session()->get('new_current_detail_id') : $request->assessment_id;
        $verify = AssessmentNew::find($assessment_id);
        $status_id = $this->assessmentStatus("02");
        $data = [
            'app_status_id' => $status_id,
            'bpk_id' => $this->generateBpkNo(),
        ];

        $response = $verify->update($data);

        $vehicle = AssessmentNewVehicle::where('assessment_new_id', $verify->id)->get();

        foreach($vehicle as $list){
            $saveStatus = AssessmentNewVehicle::find($list->id);
            $data = [
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("02"),
            ];
            $saveStatus->update($data);
        }

        // $this->sendEmailNotificationAssessmentNew($verify);
        if($response){
            return [
                    'url' => route('assessment.new.list')
                ];
        }
    }

    public function setAppointment(Request $request)
    {
        $ptj_no = $request->ptj_no;
        $assessment_id = session()->get('new_current_detail_id');
        $setAppointment = AssessmentNew::find($assessment_id);
        $data = [
            'appointment_dt' => $request->appointment_dt == 'other_appointment_dt' ?  $request->other_appoinment_dt : $request->appointment_dt,
            'assistant_engineer_by' => Auth::user()->id,
            'is_other_app_dt' => $request->appointment_dt == 'other_appointment_dt' ? true : false,
            'workshop_id' => $request->workshop_id,
            'bpk_no' => $request->bpk_no,
            'no_ptj' => $ptj_no,
        ];

        if($request->hantar){
            $data['ttl_draf'] = $setAppointment->ttl_draf - count($request->vehicle_id);
            $data['ttl_appointment'] = $setAppointment->ttl_appointment + count($request->vehicle_id);
        }
            for($i = 0; $i < count($request->vehicle_id); $i++ ){
                $setPrice = AssessmentNewVehicle::find($request->vehicle_id[$i]);
                $dataVehicle = [
                    // 'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("03"),
                    'updated_by' => auth()->user()->id,
                    'price' => $request->price[$i],
                ];
                $setPrice->update($dataVehicle);
            }

        $query = $setAppointment->update($data);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat temujanji berjaya dikemaskini',
            'url' => route('assessment.new.register', [
                'id' => $assessment_id,
                'tab' => 3
            ])
        ];

        Log::info($response);

        unset($response['query']);

        return $response;
    }

    public function examination(){
        $examination = AssessmentNew::find(session()->get('new_current_detail_id'));

        $vehicle = AssessmentNewVehicle::where('assessment_new_id', $examination->id)
                                        ->whereHas('hasAssessmentVehicleStatus', function($q){
                                            $q->where('code', '02');
                                        })->get();

        foreach($vehicle as $list){
            $saveStatus = AssessmentNewVehicle::find($list->id);
            $dataVehicle = [
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("03"),
            ];
            $saveStatus->update($dataVehicle);
        }

        $data = [
            'app_status_id' => $this->assessmentStatus("03")
            ];
        $examination->update($data);
        $this->sendEmailNotificationAssessmentNewExamUser($examination);
        return [
            'url' => route('assessment.new.list')
        ];
    }

    public function verification(){
        $examination = AssessmentNew::find(session()->get('new_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("04")
        ];
        $examination->update($data);
        return [
            'url' => route('assessment.new.list')
        ];
    }

    public function approval(Request $request){

        for($i = 0; $i < count($request->vehicle_id); $i++){
            $AssesmentNewVehicle = AssessmentNewVehicle::find($request->vehicle_id[$i]);
            if($AssesmentNewVehicle->hasAssessmentVehicleStatus->code == "05"){
                $data = [
                    'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("06"),
                    'approve_by' => auth()->user()->id,
                    'approve_dt' => Carbon::now(),
                ];
                $AssesmentNewVehicle->update($data);
            }
        }

        $examination = AssessmentNew::find(session()->get('new_current_detail_id'));
        $check = AssessmentNewVehicle::where('assessment_new_id', $examination->id)->whereHas('hasAssessmentVehicleStatus', function($q){
                                            $q->whereIn('code', ['01', '02', '03', '04','05']);
                                        })->get();
        if(count($check) == 0){
            $data = [
                'app_status_id' => $this->assessmentStatus("08")
            ];
            $examination->update($data);
            return [
                'url' => route('assessment.new.register', ['id' => session()->get('new_current_detail_id'), "tab" => 8])
            ];
        }else{
            return [
                'url' => route('assessment.new.register', ['id' => session()->get('new_current_detail_id'), "tab" => 8])
            ];
        }
        // $this->sendEmailNotification($examination);

    }

    public function saveReceipt(Request $request){
        $AssessmentNew = AssessmentNew::findOrFail($request->id);
        $data = [
            'no_receipt' => $request->receipt_no,
        ];

        $AssessmentNew->update($data);
        Log::info($AssessmentNew);
        if($AssessmentNew){
            $response = [
                'code' => 200,
                'message' => 'No Resit Berjaya Disimpan'
            ];
        }

        return $response;
    }

    public function approve(){
        $examination = AssessmentNew::find(session()->get('new_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("08")
        ];
        $examination->update($data);
        Log::info($examination->hasActiveApprovedVehicle->count());
        foreach ($examination->hasActiveApprovedVehicle as $hasActiveApprovedVehicle) {
            $hasActiveApprovedVehicle->update([
                'cert_hash_key' => Str::random(40)
            ]);
        }

        // $this->sendEmailNotification($examination);

        return [
            'url' => route('assessment.new.list')
        ];
    }


    private function generateBpkNo(){

        $query = AssessmentBpkNo::orderBy('id', 'asc')->get();
        $firstVocal = 'A'; //BPKNO
        $applicationRunningNo = str_pad(((int)$query->count() +1), 5, '0', STR_PAD_LEFT);

        $data = [
            'code' => $firstVocal.$applicationRunningNo,
        ];

        $bpk_no = AssessmentBpkNo::create($data);

        return $bpk_no->id;
    }

    private function sendEmailNotificationAssessmentNew($examination){
        $emailBody = [
            'title' => 'Permohonan Penilaian Kenderaan Baharu',
            'subject' => 'Permohonan Penilaian Kenderaan Baharu '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentNewVehicleStatus($emailBody));
    }

    private function sendEmailNotificationAssessmentNewExamUser($examination){
        $emailBody = [
            'title' => 'Temujanji Penilaian Kenderaan Baharu',
            'subject' => 'Temujanji Penilaian Kenderaan Baharu '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'appointment_dt' => $examination->appointment_dt,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentNewVehicleStatusExam($emailBody));
    }

    public function reject(){
        $examination = AssessmentNew::find(session()->get('new_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("05")
        ];
        $examination->update($data);
        return [
            'url' => route('assessment.new.list')
        ];
    }

    private function hasAssessmentVehicleStatus($code){
        $data = AssessmentVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    public function assessmentStatus($code)
    {
        $status = AssessmentApplicationStatus::where('code',$code)->first();
        return $status->id;
    }
}
