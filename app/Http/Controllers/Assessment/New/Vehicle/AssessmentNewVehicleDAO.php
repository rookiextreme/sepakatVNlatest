<?php

namespace App\Http\Controllers\Assessment\New\Vehicle;

use App\Http\Controllers\Assessment\New\AssessmentNewDAO;
use App\Mail\module\assessment\new\SendEmailToUserAssessmentNewVehicleStatus;
use App\Mail\module\assessment\new\SendEmailToUserAssessmentNewVehicleStatusAssisstEngineer;
use App\Mail\module\assessment\new\SendEmailToUserAssessmentNewVehicleStatusAssisstUser;
use App\Mail\module\assessment\new\SendEmailToUserAssessmentNewVehicleStatusEngineer;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentFormCheckDoc;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentFormCheckLvl1Selection;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use App\Models\Assessment\AssessmentFormCheckLvl3;
use App\Models\Assessment\AssessmentNewFormCheckDoc;
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

class AssessmentNewVehicleDAO
{
    public $id = -1;
    public $detail;
    public $message;

    public function list()
    {
        $assessment_new_id = session()->get('new_current_detail_id');
        $data = AssessmentNewVehicle::where('assessment_new_id', $assessment_new_id)
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
        $assessment_new_id = session()->get('new_current_detail_id');
        $data = AssessmentNewVehicle::where('assessment_new_id', $assessment_new_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00','01']);
        });
        // $price = $data::get('price');
        $totalPrice = $data->sum('price');

        // Log::info($totalprice);


        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }

        $obj = [
            'totalPrice' => $totalPrice,
            'list' => $data->latest()->paginate(5)
        ];

        return $obj;
    }

    public function listEvaluation()
    {
        $assessment_new_id = session()->get('new_current_detail_id');
        $data = AssessmentNewVehicle::where('assessment_new_id', $assessment_new_id)
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
        $assessment_new_id = session()->get('new_current_detail_id');
        $data = AssessmentNewVehicle::where('assessment_new_id', $assessment_new_id)
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
        $assessment_new_id = session()->get('new_current_detail_id');
        $data = AssessmentNewVehicle::where('assessment_new_id', $assessment_new_id)
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
            $queryAssessmentNewDetail = AssessmentNew::find(session()->get('new_current_detail_id'));
            $q->where('workshop_id', $queryAssessmentNewDetail->hasWorkShop->id)
            ->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        });
        return $query->get();
    }

    public function updatePrice(Request $request){
        $vehicle_id = $request->vehicle_id;
        $query = AssessmentNewVehicle::find($request->vehicle_id);
        $query->update([
            'price' => $request->price
        ]);
    }

    public function assignToFormen(Request $request){
        $query = AssessmentNewVehicle::find($request->vehicle_id);
        $query->update([
            'foremen_by' => $request->user_id
        ]);
    }

    public function read()
    {
        $this->detail = AssessmentNewVehicle::find($this->id);
    }

    public function upsert(Request $request)
    {
        Log::info('new_current_detail_id => '.session()->get('new_current_detail_id'));

        if($request->assessment_new_id){
            session()->put('new_current_detail_id', $request->assessment_new_id);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'sub_category_id' => 'required_with:category_id',
            // 'sub_category_type_id' => 'required_with:sub_category_id',
            'purchase_dt' => 'required',
            'company_name' => 'required',
            'lo_no' => 'required_if:is_gover,on',
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
            'category_id.required' => 'Sila pilih Kategori Kenderaan',
            'sub_category_id.required_with' => 'Sila Pilih Sub Kategori Kenderaan',
            // 'sub_category_type_id.required_with' => 'Sila Pilih Jenis Kenderaan',
            'purchase_dt.required' => 'Sila pilih Tarikh Pembelian dibuat',
            'company_name.required' => 'Sila isikan Nama Syarikat/Pembekal',
            'lo_no.required_if' => 'Sila isikan No Pesanan Kerajaan',
            'plate_no.required' => 'Sila isikan No Pendaftaran',
            // 'plate_no.unique' => 'No Pendaftaran telah digunakan',
            'engine_no.required' => 'Sila isikan No Enjin',
            'chasis_no.required' => 'Sila isikan No Chasis',
            'vehicle_brand_id.required' => 'Sila pilih Buatan',
            'model_name.required' => 'Sila isikan Model',
            'manufacture_year.required' => 'Sila pilih Tahun Dibuat',
            'registration_vehicle_dt.required' => 'Sila pilih Tarikh Pendaftaran',
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
            'assessment_new_id' => session()->get('new_current_detail_id'),
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'purchase_dt' => $request->purchase_dt,
            'company_name' => $request->company_name,
            'lo_no' => $request->lo_no ? $request->lo_no : null,
            'is_gover' => $request->is_gover ? $request->is_gover : false,
            'plate_no' => $request->plate_no,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'manufacture_year' => $request->manufacture_year,
            'registration_vehicle_dt' => $request->registration_vehicle_dt,
        ];

        $this->detail = AssessmentNewVehicle::find($request->assessment_vehicle_id);

        Log::info(session()->get('new_current_detail_id'));

        $AssessmentNew = AssessmentNew::find(session()->get('new_current_detail_id'));

        Log::info("message");

        if($this->detail){
            $dataVehicle['purchase_dt'] = $request->purchase_dt;
            $dataVehicle['registration_vehicle_dt'] = $request->registration_vehicle_dt;
            $dataVehicle['updated_by'] =  Auth::user()->id;
            $query = $this->detail->update($dataVehicle);
            $this->message = 'Maklumat Berjaya Dikemaskini';
        } else {
            $dataVehicle['assessment_vehicle_status_id'] = $this->hasAssessmentVehicleStatus("01");

            $assessmentNewVehicleId = session()->get('assessment_new_vehicle_id');
            $checkIsExisted = FleetDepartment::find($assessmentNewVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $assessmentNewVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;
            $query = AssessmentNewVehicle::create($dataVehicle);

            Log::info(session()->get('new_current_detail_id'));

            $data = [
                'ttl_draf' =>  $AssessmentNew->ttl_draf + 1,
                'ttl_vehicle' =>  $AssessmentNew->ttl_vehicle + 1,
            ];
            $AssessmentNew->update($data);
            $this->message = 'Maklumat Berjaya Ditambah';
        }

        $response = [
            'query' => $query,
            'code' => 200,
            'total_vehicle' => $AssessmentNew->hasVehicle->count(),
            'message' =>  $this->message
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function getForm(Request $request){
        $AssessmentFormCheckLvl1List = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $request->assessment_type_id,
            'vehicle_id' => $request->vehicle_id,
        ]);
        return [
            'AssessmentFormCheckLvl1List' => $AssessmentFormCheckLvl1List->get(), 
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress'
        ];
    }

    public function getVehicleForm(Request $request)
    {

        $vehicleId = $request->vehicleId;
        $data = AssessmentNewVehicle::find($vehicleId);
        $array = [
            'id' => $data->id,
            'assessment_new_id' => $data->assessment_new_id ? $data->assessment_new_id : '-',
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
        ];
        return json_encode($array);
    }

    public function saveForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'odometer' => 'required',
            // 'receipt_no' => 'required',
        ],
        [
            'odometer.required' => 'Sila isi Odometer',
            // 'receipt_no.required' => 'Sila isi No. Resit',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $request->assessment_type_id,
            'vehicle_id' => $request->vehicle_id
        ])->get();

        foreach ($checkExistFormLvl1 as $key) {
            foreach ($key->hasManySelection as $CheckList){

                if(is_array($request['form_selection_id_'.$CheckList->id])){
                    $ids = $request['form_selection_id_'.$CheckList->id];
                    $CheckList->update([
                        'selected_ids' => implode(',', $ids)
                    ]);
                } else {
                    $CheckList->update([
                        'selected_id' => $request['form_selection_id_'.$CheckList->id] ? $request['form_selection_id_'.$CheckList->id] : null
                    ]);
                }
            }
        }

        $checkExistFormLvl2 = AssessmentFormCheckLvl2::where('vehicle_id', $request->vehicle_id)->get();

        if(count($checkExistFormLvl2)>0){

            foreach ($checkExistFormLvl2 as $CheckList){

                // Log::info($request['form_check_lvl2_component_id_'.$CheckList->id]);
                // Log::info($request['form_note_lvl2_component_id_'.$CheckList->id]);
                // Log::info($request['form_file_lvl2_component_id_'.$CheckList->id]);

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

                $data = [
                    'is_pass' => $request['form_check_lvl2_component_id_'.$CheckList->id] ? true: false,
                    'note' => $request['form_note_lvl2_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id
                ];

                $CheckList->update($data);
            }
        }

        $checkExistFormLvl3 = AssessmentFormCheckLvl3::where('vehicle_id', $request->vehicle_id)->get();

        if(count($checkExistFormLvl3)>0){

            foreach ($checkExistFormLvl3 as $CheckList){
                // Log::info($request['form_check_lvl3_component_id_'.$CheckList->id]);
                // Log::info($request['form_note_lvl3_component_id_'.$CheckList->id]);
                // Log::info($request['form_file_lvl3_component_id_'.$CheckList->id]);

                    if($request['form_check_lvl3_component_id_'.$CheckList->id] !== 'on'){
                        $validator = Validator::make($request->all(), [
                            'form_note_lvl3_component_id_'.$CheckList->id => 'required',
                        ],
                        [
                            'form_note_lvl3_component_id_'.$CheckList->id.'.required' => 'Sila isikan Catatan jika gagal',
                        ]);

                        if ($validator->fails()) {
                            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                        }
                    }

                $data = [
                    'is_pass' => $request['form_check_lvl3_component_id_'.$CheckList->id] ? true: false,
                    'note' => $request['form_note_lvl3_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id
                ];

                $CheckList->update($data);
            }
        }


        $AssessmentNewVehicle = AssessmentNewVehicle::find($request->vehicle_id);
        $dataVehicle = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'evaluation_type' => $request->check_type,
            'odometer' => $request->odometer,
            'receipt_no' => $request->receipt_no,
            'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentNewVehicle->foremen_by,
            'foremen_dt' => Auth::user()->isForemenAssessment() ? Carbon::now(): $AssessmentNewVehicle->foremen_dt,
            'assessment_dt' => Auth::user()->isForemenAssessment() ? Carbon::now() : $AssessmentNewVehicle->assessment_dt,
            'assessment_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentNewVehicle->assessment_by,
            'verify_dt' => Auth::user()->isAssistEngineerAssessment() ? Carbon::now() : $AssessmentNewVehicle->verify_dt,
            'verify_by' => Auth::user()->isAssistEngineerAssessment() ? Auth::user()->id : $AssessmentNewVehicle->verify_by,
            'approve_dt' => Auth::user()->isEngineerAssessment() ? Carbon::now() : $AssessmentNewVehicle->approve_dt,
            'approve_by' => Auth::user()->isEngineerAssessment() ? Auth::user()->id : $AssessmentNewVehicle->approve_by,
        ];

        $url = null;
        if($request->save_as != 'draf'){
            $url = route('assessment.new.register', ["id"=> Request("assessment_id"), "tab" => 4]);
            if(Auth::user()->isForemenAssessment()){
                $url = route('access.operation.dashboard');
                $AssessmentNew = AssessmentNew::find($AssessmentNewVehicle->assessment_new_id);
                    $dataNew = [
                        'ttl_assess' => $AssessmentNew->ttl_assess - 1,
                        'ttl_evaluate' => $AssessmentNew->ttl_evaluate + 1,
                    ];
                $AssessmentNew->update($dataNew);
            }
            if($AssessmentNewVehicle->hasAssessmentVehicleStatus->code == '03' && auth()->user()->isForemenAssessment()){
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('04');
                $dataVehicle['in_assessment'] = false;
                $examination = AssessmentNew::find($AssessmentNewVehicle->assessment_new_id);
                // $this->sendEmailAssistEngineerNotification($examination);
            }
            if( $AssessmentNewVehicle->hasAssessmentVehicleStatus->code == '04' && auth()->user()->isAssistEngineerAssessment()){
                $url = route('assessment.new.register', ["id"=> Request("assessment_id"), "tab" => 6]);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('05');
                $AssessmentNew = AssessmentNew::find($AssessmentNewVehicle->assessment_new_id);
                    $dataNew = [
                        'ttl_evaluate' => $AssessmentNew->ttl_evaluate - 1,
                        'ttl_approve' => $AssessmentNew->ttl_approve + 1,
                    ];
                $AssessmentNew->update($dataNew);
                // $this->sendEmailEngineerNotification($AssessmentNew, $AssessmentNewVehicle);
            }
            if( $AssessmentNewVehicle->hasAssessmentVehicleStatus->code == '05' && auth()->user()->isEngineerAssessment()){
                $url = route('assessment.new.register', ["id"=> Request("assessment_id"), "tab" => 8]);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('06');
                $examination = AssessmentNew::find(session()->get('new_current_detail_id'));
                $dataVehicle['cert_hash_key'] = Str::random(40);
                $totalApprovedV = $examination->hasManyApprovedVehicle->count()+1;
                $generateRefVNumber = $examination->ref_number.'-'.$totalApprovedV;
                $dataVehicle['cert_ref_number'] = $generateRefVNumber;
                $this->sendEmailUserNotification($examination, $AssessmentNewVehicle);
            }
        }

        $AssessmentNewVehicle->update($dataVehicle);
        $examination = AssessmentNew::find($AssessmentNewVehicle->assessment_new_id);

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
            $url = route('assessment.new.register', ['id' => session()->get('new_current_detail_id'), "tab" => 6]);
        }

        if(auth()->user()->isEngineerAssessment()){

            if($examination->hasUnVerifyVehicle->count() == 0){
                $toUpdate = [
                            'app_status_id' => $this->assessmentStatus('08'),
                        ];
                $examination->update($toUpdate);
            }
            $url = route('assessment.new.register', ['id' => session()->get('new_current_detail_id'), "tab" => 8]);
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

        switch ($request->lvl) {
            case 2:
                $query = AssessmentFormCheckLvl2::find($request->id);
                $prevFileId = $query->doc_id;
                $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
                $query->update([
                    'doc_id' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
            case 3:
                $query = AssessmentFormCheckLvl3::find($request->id);
                $prevFileId = $query->doc_id;
                $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
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

    public function deleteFormFile(Request $request){
        // dd($request->all());
        switch ($request->lvl) {
            case 'lvl2':
                $query = AssessmentFormCheckLvl2::find($request->id);
                $this->deletePrevDoc2($query->doc_id);
                $query->update([
                    'doc_id' => null,
                ]);
                break;
            case 'lvl3':
                $query = AssessmentFormCheckLvl3::find($request->id);
                $this->deletePrevDoc2($query->doc_id);
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

    public function saveDocument(Request $request){
        switch ($request->lvl) {
            case 'veh_img_doc':
                $query = AssessmentNewVehicle::find($request->id);
                $prevFileId = $query->doc_id;
                $file_id = $this->createDocVeh($request->file, $request->vehicle_id)->id;
                $query->update([
                    'veh_img_doc' => $file_id
                ]);
                break;
            case 'vtl_doc':
                $query = AssessmentNewVehicle::find($request->id);
                $prevFileId = $query->doc_id;
                $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
                $query->update([
                    'vtl_doc' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
            case 'receipt_doc':
                $query = AssessmentNew::find($request->id);
                $prevFileId = $query->receipt_doc;
                $file_id = $this->createDoc($request->file, $query->id)->id;
                $query->update([
                    'receipt_doc' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
            default:
                break;
        }

        $response = [
            'code' => 200,
            'message' => 'Gambar berjaya dimuatnaik'
        ];
        return $response;
    }

    private function createDoc($file, $ref_id){

        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/assessment/new/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/new/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
            ];

            Log::info($data);

            $inserted = AssessmentFormCheckDoc::create($data);

            return $inserted;
        }
    }

    private function createDocVeh($file, $ref_id){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/assessment/new/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/new/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' =>$this->hasAssessmentType('01'),
                'vehicle_id' => $ref_id
            ];

            Log::info($data);

            return AssessmentVehicleImage::create($data);
        }
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

    private function deletePrevDoc2($id){
        Log::info('file_id => '.$id);
        $query = AssessmentFormCheckDoc::find($id);
        if($query){
            $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                    Storage::delete($path);
                    unlink($path);
                    flush();
        }
    }

    public function deleteRelatedDoc(Request $request){
        switch ($request->section) {
            case "veh_img_doc":
                $query = AssessmentVehicleImage::findOrFail($request->image_id);
                    if($query){
                        $query->delete();
                        $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                        Storage::delete($path);
                        unlink($path);
                        flush();
                    }
                break;
            case "receipt_doc":
                $query = AssessmentNew::find($request->vehicle_id);
                    $query->update([
                        'receipt_doc' => null,
                    ]);
                $query = AssessmentFormCheckDoc::findOrFail($request->image_id);
                    if($query){
                        $query->delete();
                        $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                        Storage::delete($path);
                        unlink($path);
                        flush();
                    }
                break;
            case "vtl_doc":
                $query = AssessmentNewVehicle::find($request->vehicle_id);
                    $query->update([
                        'vtl_doc' => null,
                    ]);
                $query = AssessmentFormCheckDoc::findOrFail($request->image_id);
                    if($query){
                        $query->delete();
                        $path = storage_path().'/app/public/'.$query->doc_path.$query->doc_name;
                        Storage::delete($path);
                        unlink($path);
                        flush();
                    }
                break;
            default:
                break;
        }

        $response = [
            'code' => 200,
            'message' => 'Gambar berjaya dipadam'
        ];
        return $response;
    }

    public function viewCertificate(Request $request){
        $detail = AssessmentNewVehicle::find($request->vehicle_id);
        return [
            'detail' => $detail
        ];
    }

    public function checkGenuine(Request $request){
        $key = $request->key;
        return AssessmentNewVehicle::where('cert_hash_key',$key)->first();
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = AssessmentNewVehicle::whereIn('id', $ids);
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
        $query = AssessmentNewVehicle::whereIn('id', $ids);
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
        Log::info('AssessmentNewVehicleDAO :: vehicleStatus');
        Log::info($query);
        return $query;
    }

    public function updateStatus(Request $request){
        Log::info($request);
        $vehicle_id = $request->vehicle_id;
        $vehicle_status_code = $request->status_code;
        $query = AssessmentNewVehicle::find($vehicle_id);
        $query->update([
            'assessment_vehicle_status_id' => $this->vehicleStatus($vehicle_status_code),
            'approve_by' => auth()->user()->id,
        ]);
        Log::info($query->toSql());
        Log::info($query->get());
        $check = $query->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '03');
        })->get();
        $total = count($check);

        if($total == 0){
            $url = route('assessment.new.register', ["id"=> Request("assessment_id"), "tab" => 8]);
        }else{
            $url = route('assessment.new.register', ["id"=> Request("assessment_id"), "tab" => 7]);
        }
        $AssessmentNewVehicle = $query->first();
        $AssessmentNew = AssessmentNew::find($AssessmentNewVehicle->assessment_new_id);
                    $dataNew = [
                        'ttl_approve' => $AssessmentNew->ttl_approve - 1,
                        'ttl_complete' => $AssessmentNew->ttl_complete + 1,
                    ];
            $AssessmentNew->update($dataNew);

        $findVehicle = AssessmentNewVehicle::where('assessment_new_id', $AssessmentNew->id)
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereIn('code', ['01','02','03','06']);
                                            })->get();
        $reassignStatusAssessmentNew = count($findVehicle);

        if($reassignStatusAssessmentNew == 0){
            $complete = [
                'app_status_id' => $this->assessmentStatus("08")
            ];
            $AssessmentNew->update($complete);
        }

        $response = [
            'code' => 200,
            'url' => $url,
            'message' => 'Maklumat berjaya dikemaskini'
        ];

        Log::info($response);
        return $response;
    }

    private function sendEmailAssistEngineerNotification($examination){

        $emailBody = [
            'title' => 'Pengesahan Penilaian Kenderaan Baharu',
            'subject' => 'Pengesahan Penilaian Kenderaan Baharu '.Carbon::now()->format('d/m/Y'),
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

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentNewVehicleStatusAssisstEngineer($emailBody));
    }

    private function sendEmailEngineerNotification($examination, $AssessmentNewVehicle){
        $emailBody = [
            'title' => 'Semakan Penilaian Kenderaan Baharu',
            'subject' => 'Semakan Penilaian Kenderaan Baharu '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'plate_no' => $AssessmentNewVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentNewVehicleStatusEngineer($emailBody));
    }

    private function sendEmailUserNotification($examination, $AssessmentNewVehicle){

        $emailBody = [
            'title' => 'Sijil Kenderaan Baharu',
            'subject' => 'Sijil Kenderaan Baharu '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'appointment_dt' => $examination->appointment_dt,
            'vehicle_id' => $AssessmentNewVehicle->id,
            'plate_no' => $AssessmentNewVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentNewVehicleStatusAssisstUser($emailBody));
    }

    public function getCertificateDetails(Request $request){
        // dd($request->all());
        $vehicleId = $request->vehicleId;

        $data = AssessmentNewVehicle::find($vehicleId);
        $dataAss = AssessmentNew::find($data->assessment_new_id);
        $array = [
            'id' => $data->id,
            'assessment_new_id' => $data->assessment_new_id ? $data->assessment_new_id : '-',
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
            'hod_title' => $dataAss->hod_title ? $dataAss->hod_title : '-',
            'department_name' => $dataAss->department_name ? $dataAss->department_name : '-',
        ];
        return json_encode($array);
    }

    public function editCertificateSave(Request $request){

        $vehicleId = $request->assessment_vehicle_id;
        $data = AssessmentNewVehicle::find($vehicleId);

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

        $AssessmentNew = AssessmentNew::find($data->assessment_new_id);
        $dataAssessment = [
            "hod_title" => $request->ketua_jabatan,
            "department_name" => $request->jabatan_agensi,
        ];

        $queryVehicle = $data->update($dataVehicle);
        $queryAppl = $AssessmentNew->update($dataAssessment);

        if($queryVehicle || $queryAppl){
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
}
