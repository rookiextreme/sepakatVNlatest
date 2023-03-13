<?php

namespace App\Http\Controllers\Assessment\Accident;

use App\Http\Controllers\Helpers\HelpersFunction;
use App\Mail\module\assessment\accident\SendEmailToUserAssessmentAccidentVehicleStatus;
use App\Mail\module\assessment\accident\SendEmailToUserAssessmentAccidentVehicleStatusExam;
use App\Mail\module\assessment\accident\SendNotificationToUserAssessmentAccident;
use App\Mail\module\assessment\new\SendEmailToUserAssessmentNewVehicleStatus;
use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentFormCheckDoc;
use App\Models\Assessment\AssessmentVehicleStatus;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\RefEvent;
use App\Models\RefWorkshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssessmentAccidentDAO
{

    public $id = -1;
    public $detail;
    public $detailVehicle;
    public $message;
    public $url;
    public $statusCode;

    public function list(Request $request)
    {

        $TaskFlowAssessmentAccident = auth()->user()->vehicle('02', '04');
        $TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '04');

        Log::info('AssessmentAccidentDAO :: list');

        $query = AssessmentAccident::orderBy('created_at', 'desc');
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
        } elseif (auth()->user()->isEngineer() || auth()->user()->isEngineerAssessment()){
            $query->where('workshop_id', auth()->user()->detail->workshop_id);
            if(!$this->statusCode){
                $query->whereHas('hasStatus',function($q){
                    $q->whereNotIn('code', ['00', '06']);
                });
            }
        }

        elseif(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerAssessment()){
            $query->where('workshop_id', auth()->user()->detail->workshop_id);
            if(!$this->statusCode){
                $query->whereHas('hasStatus',function($q){
                    $q->whereNotIn('code', ['00', '06']);
                });
            }
        }

        elseif(auth()->user()->isForemenAssessment()){
            $query->where('workshop_id', auth()->user()->detail->workshop_id);
            $query->whereHas('hasStatus', function($q){
                $q->where('code', '03');
            });
        }

        elseif(Auth()->user()->isPublic()){
            $query->where('created_by', Auth::user()->id);
            if(!$this->statusCode){
                $query->whereHas('hasStatus',function($q){
                    $q->whereNotIn('code', ['00', '06']);
                });
            }
        }

        if($TaskFlowAssessmentAccident->fleet_has_limit){
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
                    assessment.assessment_accident_vehicle
                WHERE
                    assessment.assessment_accident_vehicle.assessment_accident_id = assessment.assessment_accident.id 
                    AND upper(assessment.assessment_accident_vehicle.plate_no) LIKE '%".strtoupper($request->search)."%'
                ) 
            )");
        };

        $query->orWhereHas('hasStatus',function($q){
            if($this->statusCode == 'all_inprogress'){
                $q->whereNotIn('code', ['00','06','08']);
            } elseif($this->statusCode) {
                $q->where('code', $this->statusCode);
            }

        })->where('created_by', auth()->user()->id)->whereRaw("
        (upper(ref_number) LIKE '%".strtoupper($request->search)."%'
        OR EXISTS (
            SELECT
                * 
            FROM
                assessment.assessment_accident_vehicle
            WHERE
                assessment.assessment_accident_vehicle.assessment_accident_id = assessment.assessment_accident.id 
                AND upper(assessment.assessment_accident_vehicle.plate_no) LIKE '%".strtoupper($request->search)."%'
            ) 
        )");

        Log::info($query->toSql());
        if($request->mode == 'count'){
            return $query->count();
        } else {
            return $query->paginate(5);
        }
        return $query->paginate(5);
    }

    public function read(Request $request)
    {
        $id = $request->id ? $request->id : session()->get('accident_current_detail_id');

        if($request->id){
            $this->detail = AssessmentAccident::find($id);
        }

        Log::info('data'. $this->detail);
        if($this->detail){
            session()->put('accident_current_detail_id', $this->detail->id);
        }

        return $this->detail;
    }

    private function generateRefNumber($data, $workshop_id){
        $year = Carbon::now()->format('Y');
        $query = AssessmentAccident::orderBy('created_at', 'desc');
        $query->where('is_migrate', false);
        if($query->first()){
            $baseYear = Carbon::parse($query->first()->created_at)->format('Y');
        } else {
            $baseYear = Carbon::now()->format('Y');
        }

        $modulePrefix = 'N'; //Module PeNilaian
        $SubModulePrefix = 'K'; //Kemalangan

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
        // dd($request->all());
        // $request->validate([
        //     'ic_no' => 'required',
        // ],[
        //     'ic_no.required' => 'Sila isikan nama No kad pengenalan tuan',
        // ]);
        /*$request->validate([
            'applicant_name' => 'required',
            'agency_id' => 'required',
            'department_name' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'state_id' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'workshop_id' => 'required',
            'app_dates' => 'required|min:0',
        ],[
            'applicant_name.required' => 'Sila isikan nama tuan',
            'agency_id.required' => 'Sila pilih kementerian tempat tuan bekerja',
            'department_name.required' => 'Sila isikan nama jabatan tempat tuan bekerja',
            'address.required' => 'Sila isikan alamat pejabat tuan',
            'postcode.required' => 'Sila isikan poskod',
            'state_id.required' => 'Sila pilih negeri',
            'phone_no.required' => 'Kami perlukan nombor telefon tuan untuk kami hubungi',
            'email.required' => 'Kami perlukan emel tuan untuk kami hubungi sekiranya proses penilaian telah siap dijalankan nanti',
            'workshop_id.required' => 'Sila pilih woksyop yang mudah dan terdekat untuk menghantar kenderaan',
            'app_dates.required' => 'Sila cadangkan sekurang-kurangnya satu tarikh dan masa mengikut kelapangan tuan',
        ]);*/
        // $validator = Validator::make($request->all(), [
        // ],[
        // ]);
        // if ($request->fails()) {
        //     return response()->json(['success' => false, 'errors' => $request->errors()], 422);
        // }

        Log::info('accident_current_detail_id => '.session()->get('accident_current_detail_id'));

        $this->id = session()->get('accident_current_detail_id');
        $this->detail = AssessmentAccident::find($this->id);
        $data = [
            'applicant_name' => $request->applicant_name,
            'representing' => $request->representing,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'state_id' => $request->state_id,
            'department_name' => $request->department_name,
            'appointment_dt1' => $request->appointment_date_1,
            'appointment_dt2' => $request->appointment_date_2,
            'appointment_dt3' => $request->appointment_date_3,
            'agency_id' => $request->agency_id,
            'workshop_id' => $request->workshop_id
        ];

        if($this->detail){
            $data['updated_by'] =  Auth::user()->id;
            if($this->detail->hasStatus->code == '01'){
                $data['ref_number'] = $this->generateRefNumber($data, $request->workshop_id);
            }
            $query = $this->detail->update($data);
            $this->id = $this->detail->id;
            $this->message = 'Maklumat Berjaya Disimpan';
            $this->url = Route('assessment.accident.register', ['id' => $this->id, 'tab' => '2']);
        } else {
            $data['created_by'] =  Auth::user()->id;
            $data['ref_number'] = $this->generateRefNumber($data,$request->workshop_id);
            $data['app_status_id'] = $this->assessmentStatus("01");
            $query = AssessmentAccident::create($data);
            $dataVehicle = [
                'assessment_accident_id' => $query->id,
                'category_id' => '1',
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("01"),
            ];
            $query = AssessmentAccidentVehicle::create($dataVehicle);
            $this->id = $query->id;
            $this->message = 'Maklumat Berjaya Ditambah';
            $this->url = Route('assessment.accident.register', ['id' => $this->id, 'tab' => '2']);
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
        $query = AssessmentAccident::whereIn('id', $ids);
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
        $query = AssessmentAccident::whereIn('id', $ids);
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

        // $validator = Validator::make($request->all(), [
        //     'report_no' => 'required',
        //     'plate_no' => 'required',
        //     'driver_name' => 'required',
        //     'driver_mykad' => 'required',
        //     'driver_phone' => 'required',
        //     'report_dt' => 'required',
        //     'category_id' => 'required',
        //     'sub_category_id' => 'required',
        //     'sub_category_type_id' => 'required',
        // ],
        // [
        //     'report_no.required' => 'Sila Pilih Kategori Kenderaan',
        //     'plate_no.required' => 'Sila Pilih Sub Kategori Kenderaan',
        //     'driver_name.required' => 'Sila isi nama pemandu kerajaan',
        //     'driver_mykad.required' => 'Sila isi mykad pemandu',
        //     'driver_phone.required' => 'Sila isi no telefon pemandu',
        //     'report_dt.required' => 'Sila pilih tarikh',
        //     'category_id.required' => 'Sila Masukkan No Pendaftaran',
        //     'sub_category_id.required' => 'Sila Masukkan No Pendaftaran',
        //     'sub_category_type_id.required' => 'Sila Masukkan No Pendaftaran',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        // }

        $dataVehicle = [
            'assessment_accident_id' => session()->get('accident_current_detail_id'),
            'plate_no' => $request->plate_no,
            'driver_name' => $request->driver_name,
            'phone_no' => $request->phone_no,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'report_no' => $request->report_no,
            'driver_mykad' => $request->driver_mykad,
            'driver_phone' => $request->driver_phone,
            'report_dt' => $request->report_dt,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'is_gover' => $request->is_gover == 1 ? true : false,
        ];


        $AssessmentAccidentVehicle = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'));
        $check = $AssessmentAccidentVehicle->exists();

        if($check){
            $AssessmentAccidentVehicle = $AssessmentAccidentVehicle->first();
            $dataVehicle['updated_by'] = Auth::user()->id;
            $query = $AssessmentAccidentVehicle->update($dataVehicle);
            $this->message = 'Maklumat Berjaya Dikemaskini';
        }else{
            $dataVehicle['assessment_vehicle_status_id'] = $this->hasAssessmentVehicleStatus("01");
            $assessmentAccidentVehicleId = session()->get('assessment_accident_vehicle_id');
            $checkIsExisted = FleetDepartment::find($assessmentAccidentVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $assessmentAccidentVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;
            $query = AssessmentAccidentVehicle::create($dataVehicle);
            $this->message = 'Maklumat Berjaya Ditambah';
        }

        $assessment_id = session()->get('accident_current_detail_id');
        $verify = AssessmentAccident::find($assessment_id);

        $status_id = $this->assessmentStatus("02");
        $data = [
            'app_status_id' => $status_id,
            'report_no' => $request->report_no,
            'report_dt' => $request->report_dt,
        ];
        if($AssessmentAccidentVehicle->hasAssessmentVehicleStatus->code == "01"){
            $update = [
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("02"),
            ];
            $AssessmentAccidentVehicle->update($update);
        }
        // $this->sendEmailNotificationAssessmentAccident($verify);
        $verify->update($data);
        $response = [
            'query' => $query,
            'code' => 200,
            'message' =>  $this->message,
            'url' => route('assessment.accident.list'),
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function setAppointment(Request $request)
    {
        // dd($request->all());
        $assessment_id = session()->get('accident_current_detail_id');
        $setAppointment = AssessmentAccident::find($assessment_id);

        $data = [
            'appointment_dt' => $request->appointment_dt == 'other_appointment_dt' ?  $request->other_appoinment_dt : $request->appointment_dt,
            'assistant_engineer_by' => Auth::user()->id,
            'is_other_app_dt' => $request->appointment_dt == 'other_appointment_dt' ? true : false,
            'workshop_id' => $request->workshop_id,
        ];
        if($request->hantar){
            $data['ttl_draf'] = $setAppointment->ttl_draf - 1;
            $data['ttl_appointment'] = $setAppointment->ttl_appointment + 1;
        }

        $query = $setAppointment->update($data);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat temujanji berjaya dikemaskini',
            'url' => route('assessment.accident.register', [
                'id' => $assessment_id,
                'tab' => 2
            ])
        ];

        Log::info($response);

        unset($response['query']);

        return $response;
    }

    public function examination(){
        $setStatus = $this->assessmentStatus("03");
        $examination = AssessmentAccident::find(session()->get('accident_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("03")
        ];
        $data['app_status_id'] = $setStatus;
            $setStatusVehicle = AssessmentAccidentVehicle::where('assessment_accident_id', $examination->id)->first();
            $forVehicle = [
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("03"),
            ];
            $setStatusVehicle->update($forVehicle);
        $examination->update($data);
        $this->sendEmailNotificationAssessmentNewExamUser($examination);
        return [
            'url' => route('assessment.accident.list')
        ];
    }

    public function verification(Request $request){


        $examination = AssessmentAccident::find(session()->get('accident_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("04"),
        ];
        $examination->update($data);
        $setStatus = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'))->first();
        $forVehicle = [
            'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("04"),
            'odometer' => $request->odometer,
            'general_note' => $request->general_note,
        ];
        $setStatus->update($forVehicle);
        return [
            'url' => route('assessment.accident.list')
        ];
    }

    public function approval(){
        $examination = AssessmentAccident::find(session()->get('accident_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("05")
        ];
        $examination->update($data);

        $vehicle = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'))->exists();
        if($vehicle){
            $vehicle = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'))->first();
            $data = [
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("05"),
            ];
            $vehicle->update($data);
        }

        // $this->sendEmailNotification($examination);

        return [
            'url' => route('assessment.accident.register', [
                'id' => session()->get('accident_current_detail_id'),
                'tab' => 5
            ])
        ];
    }

    public function approve(){
        $examination = AssessmentAccident::find(session()->get('accident_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("08")
        ];
        $examination->update($data);

        $vehicle = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'))->exists();
        if($vehicle){
            $vehicle = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'))->first();
            $data = [
                'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus("06"),
            ];
            $vehicle->update($data);
        }
        // Log::info($examination->hasActiveApprovedVehicle->count());
        // foreach ($examination->hasActiveApprovedVehicle as $hasActiveApprovedVehicle) {
        //     $hasActiveApprovedVehicle->update([
        //         'cert_hash_key' => Str::random(40)
        //     ]);
        // }

        // $this->sendEmailNotification($examination);

        return [
            'url' => route('assessment.accident.register', [
                'id' => session()->get('accident_current_detail_id'),
                'tab' => 6
            ])
        ];
    }

    private function sendEmailNotificationAssessmentAccident($examination){
        $emailBody = [
            'title' => 'Permohonan Penilaian Kenderaan',
            'subject' => 'Permohonan Penilaian Kenderaan '.Carbon::now()->format('d/m/Y'),
            'no_pendaftaran' => $examination->hasVehicle->plate_no,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentAccidentVehicleStatus($emailBody));
    }

    private function sendEmailNotificationAssessmentNewExamUser($examination){
        $emailBody = [
            'title' => 'Temujanji Penilaian Kemalangan',
            'subject' => 'Temujanji Penilaian Kemalangan '.Carbon::now()->format('d/m/Y'),
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

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentAccidentVehicleStatusExam($emailBody));
    }

    public function reject(){
        $examination = AssessmentAccident::find(session()->get('accident_current_detail_id'));
        $data = [
            'app_status_id' => $this->assessmentStatus("05")
        ];
        $examination->update($data);
        return [
            'url' => route('assessment.accident.list')
        ];
    }

    public function assessmentStatus($code)
    {
        $status = AssessmentApplicationStatus::where('code',$code)->first();
        return $status->id;
    }

    private function hasAssessmentVehicleStatus($code){
        $data = AssessmentVehicleStatus::where('code', $code)->first();
        return $data->id;
    }
}

?>
