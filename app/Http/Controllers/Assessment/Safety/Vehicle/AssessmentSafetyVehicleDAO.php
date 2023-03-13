<?php

namespace App\Http\Controllers\Assessment\Safety\Vehicle;

use App\Http\Controllers\Assessment\Safety\AssessmentSafetyDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Mail\module\assessment\safety\SendEmailToUserAssessmentSafetyVehicleStatusAssisstEngineer;
use App\Mail\module\assessment\safety\SendEmailToUserAssessmentSafetyVehicleStatusAssisstUser;
use App\Mail\module\assessment\safety\SendEmailToUserAssessmentSafetyVehicleStatusEngineer;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentFormCheckDoc;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Assessment\AssessmentSafetyVehicle;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentFormCheckLvl1Selection;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use App\Models\Assessment\AssessmentFormCheckLvl3;
use App\Models\Assessment\AssessmentSafetyFormCheckDoc;
use App\Models\Assessment\AssessmentType;
use App\Models\Assessment\AssessmentVehicleImage;
use App\Models\Assessment\AssessmentVehicleStatus;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefEvent;
use App\Models\RefSelection;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefTableSelection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssessmentSafetyVehicleDAO
{
    public $id = -1;
    public $detail;
    public $message;

    public function list()
    {
        $assessment_safety_id = session()->get('safety_current_detail_id');
        $data = AssessmentSafetyVehicle::where('assessment_safety_id', $assessment_safety_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00']);
        });

        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }

        return $data->latest()->paginate(5);
    }

    public function listAppointment()
    {
        $assessment_safety_id = session()->get('safety_current_detail_id');
        $data = AssessmentSafetyVehicle::where('assessment_safety_id', $assessment_safety_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00','01']);
        });

        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }

        return $data->latest()->paginate(5);
    }

    public function listEvaluation()
    {
        $assessment_safety_id = session()->get('safety_current_detail_id');
        $data = AssessmentSafetyVehicle::where('assessment_safety_id', $assessment_safety_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00']);
        });

        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }

        return $data->latest()->paginate(5);
    }

    public function listApproval()
    {
        $assessment_safety_id = session()->get('safety_current_detail_id');
        $data = AssessmentSafetyVehicle::where('assessment_safety_id', $assessment_safety_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00']);
        });

        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }

        return $data->latest()->paginate(5);
    }

    public function listCertificate()
    {
        $assessment_safety_id = session()->get('safety_current_detail_id');
        $data = AssessmentSafetyVehicle::where('assessment_safety_id', $assessment_safety_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00']);
        });

        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }

        return $data->latest()->paginate(5);
    }

    public function foremenList(){
        $query = User::whereHas('roles', function($q){
            $q->where('name', '07');
        })->whereHas('detail', function($q){
            $queryAssessmentSafetyDetail = AssessmentSafety::find(session()->get('safety_current_detail_id'));
            $q->where('workshop_id', $queryAssessmentSafetyDetail->hasWorkShop->id)
            ->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        });
        return $query->get();
    }

    public function assignToFormen(Request $request){
        $query = AssessmentSafetyVehicle::find($request->vehicle_id);
        $query->update([
            'foremen_by' => $request->user_id
        ]);
    }

    public function read()
    {
        $this->detail = AssessmentSafetyVehicle::find($this->id);
    }

    public function upsert(Request $request)
    {   
        Log::info('safety_current_detail_id => '.session()->get('safety_current_detail_id'));

        if($request->assessment_safety_id){
            session()->put('safety_current_detail_id', $request->assessment_safety_id);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'sub_category_id' => 'required_with:category_id',
            // 'sub_category_type_id' => 'required_with:sub_category_id',
            //'purchase_dt' => 'required',
            //'company_name' => 'required',
            //'lo_no' => 'required_if:is_gover,on',
            'plate_no' => 'required',
            // 'plate_no' => 'required|unique:App\Models\Assessment\AssessmentAccidentVehicle,plate_no',
            'engine_no' => 'required',
            'chasis_no' => 'required',
            'vehicle_brand_id' => 'required',
            'model_name' => 'required',
            'manufacture_year' => 'required',
            'registration_vehicle_dt' => 'required',
        ],
        [
            'category_id.required' => 'Sila Pilih Kategori Kenderaan',
            'sub_category_id.required_with' => 'Sila Pilih Sub Kategori Kenderaan',
            // 'sub_category_type_id.required_with' => 'Sila Pilih Jenis Kenderaan',
            //'purchase_dt.required' => 'Sila Pilih Tarikh Beli',
            //'company_name.required' => 'Sila Masukkan Nama Syarikat/Pembekal',
            //'lo_no.required_if' => 'Sila Masukkan No Pesanan Kerajaan',
            'plate_no.required' => 'Sila Masukkan No Pendaftaran',
            // 'plate_no.unique' => 'No Pendaftaran telah digunakan',
            'engine_no.required' => 'Sila Masukkan No Enjin',
            'chasis_no.required' => 'Sila Masukkan No Chasis',
            'vehicle_brand_id.required' => 'Sila Pilih Buatan',
            'model_name.required' => 'Sila Masukkan Model',
            'manufacture_year.required' => 'Sila Pilih Tahun Dibuat',
            'registration_vehicle_dt.required' => 'Sila Pilih Tarikh Pendaftaran',
        ]);



        $hasChildVSubCat = RefSubCategory::where([
            'category_id' => $request->category_id,
            'status' => 1
        ])->count();

        $hasChildVType = RefSubCategoryType::where([
            'sub_category_id' => $request->sub_category_id,
            'status' => 1
        ])->count();

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        } else if(!$request->category_id && $hasChildVSubCat > 0){
            return response()->json(['success' => false, 'errors' => [
                'sub_category_id' => ['Sila pilih sub kategori']
            ]], 422);
        } else if(!$request->sub_category_type_id && $hasChildVType > 0){
            return response()->json(['success' => false, 'errors' => [
                'sub_category_type_id' => ['Sila pilih jenis kenderaan']
            ]], 422);
        }

        $dataVehicle = [
            'assessment_safety_id' => session()->get('safety_current_detail_id'),
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            //'purchase_dt' => $request->purchase_dt,
            //'company_name' => $request->company_name,
            //'is_gover' => $request->is_gover ? $request->is_gover : false,
            'plate_no' => $request->plate_no,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'manufacture_year' => $request->manufacture_year,
            'registration_vehicle_dt' => $request->registration_vehicle_dt
        ];

        $this->detail = AssessmentSafetyVehicle::find($request->assessment_vehicle_id);

        Log::info('safety_current_detail_id => '.session()->get('safety_current_detail_id'));

        $AssessmentSafety = AssessmentSafety::find(session()->get('safety_current_detail_id'));

        Log::info("message");

        if($this->detail){
            // $dataVehicle['purchase_dt'] = $this->convertDateToSQLDateTime($request->purchase_dt, 'Y-m-d');
            $dataVehicle['registration_vehicle_dt'] = $request->registration_vehicle_dt;
            $dataVehicle['updated_by'] =  Auth::user()->id;
            $query = $this->detail->update($dataVehicle);
            $this->message = 'Maklumat Berjaya Dikemaskini';
        } else {

            $dataVehicle['assessment_vehicle_status_id'] = $this->hasAssessmentVehicleStatus("01");

            $assessmentSafetyVehicleId = session()->get('assessment_safety_vehicle_id');
            $checkIsExisted = FleetDepartment::find($assessmentSafetyVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $assessmentSafetyVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;
            $query = AssessmentSafetyVehicle::create($dataVehicle);
            $data = [
                'ttl_draf' =>  0,
                'ttl_vehicle' =>  0,
            ];
            Log::info($AssessmentSafety);
            $AssessmentSafety->update($data);
            $this->message = 'Maklumat Berjaya Ditambah';
        }

        $AssessmentSafety = AssessmentSafety::find(session()->get('safety_current_detail_id'));

        $response = [
            'query' => $query,
            'code' => 200,
            'total_vehicle' => $AssessmentSafety->hasVehicle->count(),
            'message' =>  $this->message
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function getForm(Request $request){
        $AssessmentFormCheckLvl1List = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $request->assessment_type_id,
            'vehicle_id' => $request->vehicle_id
        ]);
        // $AssessmentFormCheckLvl1forPengujianList = $AssessmentFormCheckLvl1List->where('checklistlvl1_id', 204);

        return [
            'AssessmentFormCheckLvl1List' => $AssessmentFormCheckLvl1List->get(),
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress'

            // 'AssessmentFormCheckLvl1forPengujianList' => $AssessmentFormCheckLvl1forPengujianList->first(),
        ];
    }

    public function getVehicleForm(Request $request)
    {

        $vehicleId = $request->vehicleId;
        $data = AssessmentSafetyVehicle::find($vehicleId);
        $array = [
            'id' => $data->id,
            'assessment_safety_id' => $data->assessment_safety_id ? $data->assessment_safety_id : '-',
            'category_id' => $data->category_id ? $data->category_id : '-',
            'sub_category_id' => $data->sub_category_id ? $data->sub_category_id : '-',
            'sub_category_type_id' => $data->sub_category_type_id ? $data->sub_category_type_id : '-',
            'vehicle_brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            //'purchase_dt' => $data->purchase_dt ? $data-> : '-',
            //'company_name' => $data->company_name ? $data-> : '-',
            //'lo_no' => $data->lo_no ? $data-> : '-',
            //'is_gover' => $data->is_gover ? $data-> : '-',
            'plate_no' => $data->plate_no ? $data->plate_no : '-',
            'engine_no' => $data->engine_no ? $data->engine_no : '-',
            'chasis_no' => $data->chasis_no ? $data->chasis_no : '-',
            'brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'model_name' => $data->model_name ? $data->model_name : '-',
            'manufacture_year' => $data->manufacture_year ? $data->manufacture_year : '-',
            'registration_vehicle_dt' => $data->registration_vehicle_dt ? $data->registration_vehicle_dt : null,
            'category_name' => $data->hasCategory ? $data->hasCategory->name : '-',
            'subCat_name' => $data->hasSubcategory ? $data->hasSubcategory->name : '-',
            'subCatTy_name' => $data->hasSubCategoryType ? $data->hasSubCategoryType->name : '-',
            'brand_name' => $data->hasVehicleBrand ? $data->hasVehicleBrand->name : '-',
        ];
        return json_encode($array);
    }

    public function saveForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'odometer' => 'required',
        ],
        [
            'odometer.required' => 'Sila isi Odometer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $check_pass_lvl2 = 0;
        $check_pass_lvl3 = 0;
        Log::info($request);
        $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $request->assessment_type_id,
            'vehicle_id' => $request->vehicle_id
        ])->first();

        Log::info($checkExistFormLvl1);
        foreach ($checkExistFormLvl1->hasManySelection as $CheckList){
            Log::info($request['form_selection_id_'.$CheckList->id]);
            $CheckList->update([
                'selected_id' => $request['form_selection_id_'.$CheckList->id] ? $request['form_selection_id_'.$CheckList->id] : null
            ]);
        }


        $checkExistFormLvl2 = AssessmentFormCheckLvl2::where('vehicle_id', $request->vehicle_id)
        ->whereHas('hascheckListLvl1', function($q) use($request){
            $q->where('assessment_type_id', $request->assessment_type_id);
        })
        ->get();

        if(count($checkExistFormLvl2)>0){

            foreach ($checkExistFormLvl2 as $CheckList){
                Log::info($request['form_check_lvl2_component_id_'.$CheckList->id]);
                Log::info($request['form_note_lvl2_component_id_'.$CheckList->id]);
                Log::info($request['form_file_lvl2_component_id_'.$CheckList->id]);

                // if($request['form_check_lvl2_component_id_'.$CheckList->id] !== 'on'){
                //     if('form_note_lvl2_component_id_'.$CheckList->id){
                //         $validator = Validator::make($request->all(), [
                //             'form_note_lvl2_component_id_'.$CheckList->id => 'required',
                //         ],
                //         [
                //             'form_note_lvl2_component_id_'.$CheckList->id.'.required' => 'Sila isikan Catatan jika gagal',
                //         ]);

                //         if ($validator->fails()) {
                //             return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                //         }
                //     }
                // }

                $is_pass_lvl2 = $request['form_check_lvl2_component_id_'.$CheckList->id] ? true: false;
                $data = [
                    'is_pass' => $is_pass_lvl2,
                    'note' => $request['form_note_lvl2_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id
                ];

                $CheckList->update($data);
                if($is_pass_lvl2 == false){
                    $check_pass_lvl2 += 1;
                }

            }
            // dd($checkExistFormLvl2);
        }

        $checkExistFormLvl3 = AssessmentFormCheckLvl3::where('vehicle_id', $request->vehicle_id)
        ->whereHas('hascheckListLvl2', function($q) use($request){
            $q->whereHas('hascheckListLvl1', function($q2) use($request){
                $q2->where('assessment_type_id', $request->assessment_type_id);
            });
        })
        ->get();
        // Log::info($checkExistFormLvl3);
        if(count($checkExistFormLvl3)>0){

            foreach ($checkExistFormLvl3 as $CheckList){
                Log::info($request['form_check_lvl3_component_id_'.$CheckList->id]);
                Log::info($request['form_note_lvl3_component_id_'.$CheckList->id]);
                Log::info($request['form_file_lvl3_component_id_'.$CheckList->id]);


                // if($request['form_check_lvl3_component_id_'.$CheckList->id] !== 'on'){
                //     $validator = Validator::make($request->all(), [
                //         'form_note_lvl3_component_id_'.$CheckList->id => 'required',
                //     ],
                //     [
                //         'form_note_lvl3_component_id_'.$CheckList->id.'.required' => 'Sila isikan Catatan jika gagal',
                //     ]);

                //     if ($validator->fails()) {
                //         return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                //     }
                // }

                $is_pass_lvl3 = $request['form_check_lvl3_component_id_'.$CheckList->id] ? true: false;

                $data = [
                    'is_pass' => $is_pass_lvl3,
                    'note' => $request['form_note_lvl3_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id
                ];

                $CheckList->update($data);
                if($is_pass_lvl3 == false){
                    $check_pass_lvl3 += 1;
                }
            }
        }

        $AssessmentSafetyVehicle = AssessmentSafetyVehicle::find($request->vehicle_id);
        $dataVehicle = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'odometer' => $request->odometer,
            'evaluation_type' => $request->check_type,
            'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentSafetyVehicle->foremen_by,
            'foremen_dt' => Auth::user()->isForemenAssessment() ? Carbon::now(): $AssessmentSafetyVehicle->foremen_dt,
            'assessment_dt' => Auth::user()->isForemenAssessment() ? Carbon::now() : $AssessmentSafetyVehicle->assessment_dt,
            'assessment_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentSafetyVehicle->assessment_by,
            'verify_dt' => Auth::user()->isAssistEngineerAssessment() ? Carbon::now() : $AssessmentSafetyVehicle->verify_dt,
            'verify_by' => Auth::user()->isAssistEngineerAssessment() ? Auth::user()->id : $AssessmentSafetyVehicle->verify_by,
            'approve_dt' => Auth::user()->isEngineerAssessment() ? Carbon::now() : $AssessmentSafetyVehicle->approve_dt,
            'approve_by' => Auth::user()->isEngineerAssessment() ? Auth::user()->id : $AssessmentSafetyVehicle->approve_by,
        ];

        Log::info('check pass');

        Log::info($check_pass_lvl2);
        Log::info($check_pass_lvl3);
        // dd($check_pass_lvl2, $check_pass_lvl3);
        $url = null;
        if($request->save_as != 'draf'){
            $url = route('assessment.safety.register', ["id"=> Request("assessment_id"), "tab" => 4]);
            if(Auth::user()->isForemenAssessment()){
                $url = route('access.operation.dashboard');
                $AssessmentSafety = AssessmentSafety::find($AssessmentSafetyVehicle->assessment_safety_id);
                    $dataNew = [
                        'ttl_assess' => $AssessmentSafety->ttl_assess - 1,
                        'ttl_evaluate' => $AssessmentSafety->ttl_evaluate + 1,
                    ];
                $AssessmentSafety->update($dataNew);
            }
            if($AssessmentSafetyVehicle->hasAssessmentVehicleStatus->code == '03' && auth()->user()->isForemenAssessment()){
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('04');
                $dataVehicle['in_assessment'] = false;
                $examination = AssessmentSafety::find($AssessmentSafetyVehicle->assessment_new_id);
                // $this->sendEmailAssistEngineerNotification($examination);
            }
            if( $AssessmentSafetyVehicle->hasAssessmentVehicleStatus->code == '04' && auth()->user()->isAssistEngineerAssessment()){
                $url = route('assessment.safety.register', ["id"=> Request("assessment_id"), "tab" => 6]);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('05');
                $AssessmentSafety = AssessmentSafety::find($AssessmentSafetyVehicle->assessment_safety_id);
                    $dataSafety = [
                        'ttl_evaluate' => $AssessmentSafety->ttl_evaluate - 1,
                        'ttl_approve' => $AssessmentSafety->ttl_approve + 1,
                    ];
                $AssessmentSafety->update($dataSafety);
                // $this->sendEmailEngineerNotification($AssessmentSafety, $AssessmentSafetyVehicle);
            }
            if( $AssessmentSafetyVehicle->hasAssessmentVehicleStatus->code == '05' && auth()->user()->isEngineerAssessment()){
                $url = route('assessment.safety.register', ["id"=> Request("assessment_id"), "tab" => 8]);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('06');
                $examination = AssessmentSafety::find(session()->get('safety_current_detail_id'));
                $dataVehicle['cert_hash_key'] = Str::random(40);
                $totalApprovedV = $examination->hasManyApprovedVehicle->count()+1;
                $generateRefVNumber = $examination->ref_number.'-'.$totalApprovedV;
                $dataVehicle['cert_ref_number'] = $generateRefVNumber;
                $dataVehicle['expiry_dt'] = Carbon::parse($AssessmentSafetyVehicle->assessment_dt)->addYears(1)->subDays(1);

                $helpers = new HelpersFunction();
                $safetyDt = $dataVehicle['approve_dt'];
                $helpers->findPlateNoAndUpdateSafetyDt($AssessmentSafetyVehicle->plate_no, $safetyDt);

                $examination->update($dataVehicle);

                $this->sendEmailUserNotification($examination, $AssessmentSafetyVehicle);
            }

            $dataVehicle['approval'] = ($check_pass_lvl2 == 0 && $check_pass_lvl3 == 0) ? true : false;
        }

        $AssessmentSafetyVehicle->update($dataVehicle);
        $examination = AssessmentSafety::find($AssessmentSafetyVehicle->assessment_safety_id);

        if(auth()->user()->isForemenAssessment()){
            if($examination->hasActiveVerifyVehicle->count() == 0){
                $toUpdate = [
                            'app_status_id' => $this->assessmentStatus('04'),
                        ];
                $examination->update($toUpdate);
            }
        }

        if(auth()->user()->isAssistEngineerAssessment()){
            if($examination->hasActiveApprovedVehicle->count() == 0){
                $toUpdate = [
                            'app_status_id' => $this->assessmentStatus('05'),
                        ];
                $examination->update($toUpdate);
            }
            $url = route('assessment.safety.register', ['id' => session()->get('safety_current_detail_id'), "tab" => 6]);
        }

        if(auth()->user()->isEngineerAssessment()){

            if($examination->hasUnVerifyVehicle->count() == 0){
                $toUpdate = [
                            'app_status_id' => $this->assessmentStatus('08'),
                        ];
                $examination->update($toUpdate);
            }
            $url = route('assessment.safety.register', ['id' => session()->get('safety_current_detail_id'), "tab" => 8]);
        }

        $response = [
            'code' => 200,
            'url' => $url,
            'message' => 'Maklumat semakan kenderaan berjaya dikemaskini'
        ];

        Log::info($response);
        return $response;
    }

    public function saveFormFile(Request $request){

        $assessment_type_id = $request->assessment_type_id;
        $file_id = $this->createDoc($request->file, $request->vehicle_id, $assessment_type_id)->id;
        switch ($request->lvl) {
            case 'veh_img_doc':
                $query = AssessmentSafetyVehicle::find($request->id);
                $prevFileId = $query->doc_id;
                $file_id = $this->createDocVeh($request->file, $request->vehicle_id)->id;
                $query->update([
                    'veh_img_doc' => $file_id
                ]);
                break;
            case 'vtl_doc':
                $query = AssessmentSafetyVehicle::find($request->id);
                $prevFileId = $query->vtl_doc;
                $query->update([
                    'vtl_doc' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
            case 2:
                $query = AssessmentFormCheckLvl2::find($request->id);
                $prevFileId = $query->doc_id;
                $query->update([
                    'doc_id' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
            case 3:
                $query = AssessmentFormCheckLvl3::find($request->id);
                $prevFileId = $query->doc_id;
                $query->update([
                    'doc_id' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
        }

        $response = [
            'code' => 200,
            'message' => 'Gambar berjaya dimuatnaik'
        ];
        return $response;
    }

    private function createDoc($file, $ref_id, $assessment_type_id){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/assessment/safety/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/safety/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' => $assessment_type_id,
            ];

            Log::info($data);

            return AssessmentFormCheckDoc::create($data);
        }
    }

    private function createDocVeh($file, $ref_id){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/assessment/safety/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/safety/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' =>$this->hasAssessmentType('02'),
                'vehicle_id' => $ref_id
            ];

            Log::info($data);

            return AssessmentVehicleImage::create($data);
        }
    }

    public function deleteFormFile(Request $request){
        // dd($request->all());
        switch ($request->lvl) {
            case 'veh_img_doc':
                // dd($request->all());
                $query = AssessmentVehicleImage::findOrFail($request->id);
                    if($query){
                        $query->delete();
                        $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                        Storage::delete($path);
                        unlink($path);
                        flush();
                    }
                break;
            case 'vtl_doc':
                $query = AssessmentSafetyVehicle::find($request->id);
                $this->deletePrevDoc2($query->vtl_doc, $request->lvl);
                $query->update([
                    'vtl_doc' => null,
                ]);
                break;
            case 'lvl2':
                $query = AssessmentFormCheckLvl2::find($request->id);
                $this->deletePrevDoc2($query->doc_id, $request->lvl);;
                $query->update([
                    'doc_id' => null,
                ]);
                break;
            case 'lvl3':
                $query = AssessmentFormCheckLvl3::find($request->id);
                $this->deletePrevDoc2($query->doc_id, $request->lvl);
                $query->update([
                    'doc_id' => null,
                ]);
                break;
        }

        $response = [
            'code' => 200,
            'message' => 'Gambar berjaya dipadam'
        ];
        return $response;
    }

    private function deletePrevDoc($id){
        Log::info('file_id => '.$id);
        $query = AssessmentFormCheckDoc::find($id);
        if($query){
            $query->delete();
            $path = public_path().'/storage/'.$query->doc_path.$query->doc_name;
            unlink($path);
            flush();
        }
    }

    private function deletePrevDoc2($id, $type){
        Log::info('file_id => '.$id);
        switch($type){
            case 'vtl_doc':
                $query = AssessmentFormCheckDoc::find($id);
                if($query){
                    $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                            Storage::delete($path);
                            unlink($path);
                            flush();
                }
                break;
            case 'lvl2':
                $query = AssessmentFormCheckDoc::find($id);
                if($query){
                    $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                            Storage::delete($path);
                            unlink($path);
                            flush();
                }
                break;
            case 'lvl3':
                $query = AssessmentFormCheckDoc::find($id);
                if($query){
                    $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                            Storage::delete($path);
                            unlink($path);
                            flush();
                }
                break;
            default:
                break;
        }
    }

    public function viewCertificate(Request $request){
        $detail = AssessmentSafetyVehicle::find($request->vehicle_id);
        return [
            'detail' => $detail
        ];
    }

    public function checkGenuine(Request $request){
        $key = $request->key;
        return AssessmentSafetyVehicle::where('cert_hash_key',$key)->first();
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = AssessmentSafetyVehicle::whereIn('id', $ids);
        $query->delete();
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
        $cancel = [
            'assessment_vehicle_status_id' => $this->hasAssessmentVehicleStatus('00')
        ];
        $query = AssessmentSafetyVehicle::whereIn('id', $ids);
        $query->update($cancel);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

    private function vehicleStatus($code){
        Log::info($code);
        $query = AssessmentVehicleStatus::where('code', $code)->first()->id;
        Log::info('AssessmentSafetyVehicleDAO :: vehicleStatus');
        Log::info($query);
        return $query;
    }

    public function updateStatus(Request $request){
        Log::info($request);
        $vehicle_id = $request->vehicle_id;
        $vehicle_status_code = $request->status_code;
        $query = AssessmentSafetyVehicle::find($vehicle_id);
        $query->update([
            'assessment_vehicle_status_id' => $this->vehicleStatus($vehicle_status_code)
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dikemaskini'
        ];

        Log::info($response);
        return $response;
    }

    private function sendEmailAssistEngineerNotification($examination){

        $emailBody = [
            'title' => 'Pengesahan Penilaian Keselematan & Prestasi',
            'subject' => 'Pengesahan Penilaian Keselematan & Prestasi '.Carbon::now()->format('d/m/Y'),
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

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentSafetyVehicleStatusAssisstEngineer($emailBody));
    }

    private function sendEmailEngineerNotification($examination, $AssessmentSafetyVehicle){
        $emailBody = [
            'title' => 'Semakan Penilaian Keselematan & Prestasi',
            'subject' => 'Semakan Penilaian Keselematan & Prestasi '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'plate_no' => $AssessmentSafetyVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentSafetyVehicleStatusEngineer($emailBody));
    }

    private function sendEmailUserNotification($examination, $AssessmentSafetyVehicle){

        $emailBody = [
            'title' => 'Sijil Keselamatan & Prestasi',
            'subject' => 'Sijil Keselamatan & Prestasi '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'appointment_dt' => $examination->appointment_dt,
            'vehicle_id' => $AssessmentSafetyVehicle->id,
            'plate_no' => $AssessmentSafetyVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentSafetyVehicleStatusAssisstUser($emailBody));
    }

    public function getCertificateDetails(Request $request){
        // dd($request->all());
        $vehicleId = $request->vehicleId;

        $data = AssessmentSafetyVehicle::find($vehicleId);
        $dataAssessment = AssessmentSafety::find($data->assessment_safety_id);
        $array = [
            'id' => $data->id,
            'assessment_safety_id' => $data->assessment_safety_id ? $data->assessment_safety_id : '-',
            'category_id' => $data->category_id ? $data->category_id : '-',
            'category_name' => $data->hasCategory ? $data->hasCategory->name : '-',
            'sub_category_id' => $data->sub_category_id ? $data->sub_category_id : '-',
            'subCat_name' => $data->hasSubcategory ? $data->hasSubcategory->name : '-',
            'sub_category_type_id' => $data->sub_category_type_id ? $data->sub_category_type_id : '-',
            'subCatTy_name' => $data->hasSubCategoryType ? $data->hasSubCategoryType->name : '-',
            'vehicle_brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'purchase_dt' => $data->purchase_dt ? $data->purchase_dt : null,
            'company_name' => $data->company_name ? $data->company_name : '-',
            'lo_no' => $data->lo_no ? $data->lo_no : '-',
            'is_gover' => $data->is_gover,
            'plate_no' => $data->plate_no ? $data->plate_no : '-',
            'engine_no' => $data->engine_no ? $data->engine_no : '-',
            'chasis_no' => $data->chasis_no ? $data->chasis_no : '-',
            'brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'brand_name' => $data->hasVehicleBrand ? $data->hasVehicleBrand->name : '-',
            'model_name' => $data->model_name ? $data->model_name : '-',
            'manufacture_year' => $data->manufacture_year ? $data->manufacture_year : '-',
            'registration_vehicle_dt' => $data->registration_vehicle_dt ? $data->registration_vehicle_dt : null,
            'odometer' => $data->odometer ? $data->odometer : '-',
            // 'hod_title' => $dataAssessment->hod_title ? $dataAssessment->hod_title : '-',
            // 'department_name' => $dataAssessment->department_name ? $dataAssessment->department_name : '-',
        ];
        return json_encode($array);
    }

    public function editCertificateSave(Request $request){

        $vehicleId = $request->assessment_vehicle_id;
        $data = AssessmentSafetyVehicle::find($vehicleId);

        $dataVehicle = [
            "plate_no" => $request->plate_no,
            "engine_no" => $request->engine_no,
            "chasis_no" => $request->chasis_no,
            "vehicle_brand_id" => $request->vehicle_brand_id,
            "model_name" => $request->model_name,
            "category_id" => $request->category_id,
            "sub_category_id" => $request->sub_category_id,
            "sub_category_type_id" => $request->sub_category_type_id,
            "odometer" => $request->odometer,
            "reason_changed" => $request->reason_changed,
        ];

        // $AssessmentSafety = AssessmentSafety::find($data->assessment_safety_id);
        // $dataAssessment = [
        //     "hod_title" => $request->ketua_jabatan,
        //     "department_name" => $request->jabatan_agensi,
        // ];

        $queryVehicle = $data->update($dataVehicle);
        // $queryAppl = $AssessmentSafety->update($dataAssessment);

        if($queryVehicle){
            $message = "Maklumat Berjaya Dikemaskini";
        }

        $response = [
            'code' => 200,
            'message' =>  $message,
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
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

    public function hasAssessmentType($code)
    {
        $type = AssessmentType::where('code', $code)->first();
        return $type->id;
    }

    public function checkListFailed(Request $request){

        $checkListFailed = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $request->assessment_type_id,
            'vehicle_id' => $request->vehicle_id
        ])->get();

        return $checkListFailed;

    }
}
