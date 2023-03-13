<?php

namespace App\Http\Controllers\Assessment\Disposal\Vehicle;

use App\Http\Controllers\Assessment\Disposal\AssessmentDisposalDAO;
use App\Mail\module\assessment\disposal\SendEmailToUserAssessmentDisposalVehicleStatusAssisstEngineer;
use App\Mail\module\assessment\disposal\SendEmailToUserAssessmentDisposalVehicleStatusAssisstUser;
use App\Mail\module\assessment\disposal\SendEmailToUserAssessmentDisposalVehicleStatusEngineer;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentDisposalVehicle;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentFormCheckLvl1Selection;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use App\Models\Assessment\AssessmentFormCheckLvl3;
use App\Models\Assessment\AssessmentDisposalFormCheckDoc;
use App\Models\Assessment\AssessmentDisposalPercentage;
use App\Models\Assessment\AssessmentFormCheckDoc;
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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssessmentDisposalVehicleDAO
{
    public $id = -1;
    public $detail;
    public $message;

    public function list()
    {
        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $data = AssessmentDisposalVehicle::where('assessment_disposal_id', $assessment_disposal_id)
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
        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $data = AssessmentDisposalVehicle::where('assessment_disposal_id', $assessment_disposal_id)
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
        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $data = AssessmentDisposalVehicle::where('assessment_disposal_id', $assessment_disposal_id)
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
        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $data = AssessmentDisposalVehicle::where('assessment_disposal_id', $assessment_disposal_id)
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
        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $data = AssessmentDisposalVehicle::where('assessment_disposal_id', $assessment_disposal_id)
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
            $queryAssessmentDisposalDetail = AssessmentDisposal::find(session()->get('disposal_current_detail_id'));
            $q->where('workshop_id', $queryAssessmentDisposalDetail->hasWorkShop->id)
            ->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        });
        return $query->get();
    }

    public function assignToFormen(Request $request){
        $query = AssessmentDisposalVehicle::find($request->vehicle_id);
        $query->update([
            'foremen_by' => $request->user_id
        ]);
    }

    public function read()
    {
        $this->detail = AssessmentDisposalVehicle::find($this->id);
    }

    public function upsert(Request $request)
    {
        if($request->assessment_disposal_id){
            session()->put('disposal_current_detail_id', $request->assessment_disposal_id);
        }
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'sub_category_id' => 'required_with:category_id',
            'purchase_dt' => 'required',
            'aset_regno' => 'required',
            //'nc_no' => 'required',
            'plate_no' => 'required',
            // 'location' => 'required',
            'original_price' => 'required',
            'engine_no' => 'required',
            'chasis_no' => 'required',
            'vehicle_brand_id' => 'required',
            'model_name' => 'required',
            'manufacture_year' => 'required',
            'registration_vehicle_dt' => 'required',
            'earlier_maintenance_cost' => 'required',
        ],
        [
            'category_id.required' => 'Sila pilih kategori kenderaan',
            'sub_category_id.required_with' => 'Sila pilih sub kategori kenderaan',
            'purchase_dt.required' => 'Sila pilih tarikh beli',
            'aset_regno.required' => 'Sila isi nama ',
            //'nc_no.required' => 'Sila isi kodifikasi nasional',
            'plate_no.required' => 'Sila isi no pendaftaran',
            // 'location.required' => 'Sila isi lokasi kenderaan',
            'original_price.required' => 'Sila masukkan harga asal',
            'engine_no.required' => 'Sila isi no. enjin',
            'chasis_no.required' => 'Sila isi no. casis',
            'vehicle_brand_id.required' => 'Sila pilih jenis buatan kenderaan',
            'model_name.required' => 'Sila isi nama model',
            'manufacture_year.required' => 'Sila pilih tahun dibuat',
            'registration_vehicle_dt.required' => 'Sila pilih tarikh pendaftaran',
            'earlier_maintenance_cost.required' => 'Sila isi kos penyelenggaraan',
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
            'assessment_disposal_id' => session()->get('disposal_current_detail_id'),
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'purchase_dt' => $request->purchase_dt,
            'aset_regno' => $request->aset_regno,
            'nc_no' => $request->nc_no ? $request->nc_no : false,
            'plate_no' => $request->plate_no,
            'location' => $request->location,
            'original_price' => preg_replace('/,/', '', $request->original_price),
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'manufacture_year' => $request->manufacture_year,
            'registration_vehicle_dt' => $request->registration_vehicle_dt,
            'is_move' => $request->is_move ? true : false,
            'earlier_maintenance_cost' => preg_replace('/,/', '', $request->earlier_maintenance_cost),
            // 'other_sub_category_type' => $request->other_sub_category_type,
            // 'earlier_maintenance_cost' => (float) str_replace(',', '', $request->earlier_maintenance_cost),
        ];

        $this->detail = AssessmentDisposalVehicle::find($request->assessment_vehicle_id);
        $AssessmentDisposal = AssessmentDisposal::find(session()->get('disposal_current_detail_id'));

        if($this->detail){
            // dd($request->all());
            $dataVehicle['registration_vehicle_dt'] = $request->registration_vehicle_dt;
            $dataVehicle['purchase_dt'] = $request->purchase_dt;
            $dataVehicle['updated_by'] =  Auth::user()->id;
            $query = $this->detail->update($dataVehicle);
            $this->message = 'Maklumat Berjaya Dikemaskini';
        } else {

            $dataVehicle['assessment_vehicle_status_id'] = $this->hasAssessmentVehicleStatus("01");

            $assessmentDisposalVehicleId = session()->get('assessment_disposal_vehicle_id');
            $checkIsExisted = FleetDepartment::find($assessmentDisposalVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $assessmentDisposalVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;
            $query = AssessmentDisposalVehicle::create($dataVehicle);
            $data = [
                'ttl_draf' =>  $AssessmentDisposal->ttl_draf + 1,
                'ttl_vehicle' =>  $AssessmentDisposal->ttl_vehicle + 1,
            ];
            $AssessmentDisposal->update($data);
            $this->message = 'Maklumat Berjaya Ditambah';
        }

        $response = [
            'query' => $query,
            'code' => 200,
            'total_vehicle' => $AssessmentDisposal->hasVehicle->count(),
            'message' =>  $this->message
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function updateCost(Request $request){

        $AssessmentDisposalVehicle = AssessmentDisposalVehicle::find($request->assessment_vehicle_id);
        // $AssessmentDisposal = AssessmentDisposal::find(session()->get('disposal_current_detail_id'));

        $data = [
            'earlier_maintenance_cost' => preg_replace('/,/', '', $request->earlier_maintenance_cost)
        ];

        if($AssessmentDisposalVehicle){
            Log::info("masuk data");
            $AssessmentDisposalVehicle->update($data);
            $AssessmentDisposalVehicle->message = 'Maklumat Berjaya Dikemaskini';
        } 
        $response = [
            'AssessmentDisposalVehicle' => $AssessmentDisposalVehicle,
            'code' => 200,
            'message' =>  $AssessmentDisposalVehicle->message
        ];

        Log::info($response);
        return $response;
    }

    public function getForm(Request $request){
        $AssessmentFormCheckLvl1List = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $request->assessment_type_id,
            'vehicle_id' => $request->vehicle_id
        ])->whereHas('hasComponentLvl1', function($q){
            return $q->orderBy('code');
        });
        return [
            'AssessmentFormCheckLvl1List' => $AssessmentFormCheckLvl1List->get()
        ];
    }

    public function getVehicleForm(Request $request)
    {
        Log::info("sini => ".$request->vehicleId);
        $vehicleId = $request->vehicleId;
        $data = AssessmentDisposalVehicle::find($vehicleId);
        $array = [
            'id' => $data->id,
            'assessment_disposal_id' => $data->assessment_disposal_id ? $data->assessment_disposal_id : '-',
            'category_id' => $data->category_id ? $data->category_id : '-',
            'sub_category_id' => $data->sub_category_id ? $data->sub_category_id : '-',
            'sub_category_type_id' => $data->sub_category_type_id ? $data->sub_category_type_id : '-',
            'vehicle_brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'location' => $data->location ? $data->location : '-',
            'is_move' => $data->is_move,
            'plate_no' => $data->plate_no ? $data->plate_no : '-',
            'engine_no' => $data->engine_no ? $data->engine_no : '-',
            'chasis_no' => $data->chasis_no ? $data->chasis_no : '-',
            'model_name' => $data->model_name ? $data->model_name : '-',
            'manufacture_year' => $data->manufacture_year ? $data->manufacture_year : '-',
            'registration_vehicle_dt' => $data->registration_vehicle_dt ? $data->registration_vehicle_dt : null,
            'aset_regno' => $data->aset_regno ? $data->aset_regno : '-',
            'nc_no' => $data->nc_no ? $data->nc_no : '-',
            'purchase_dt' => $data->purchase_dt ? $data->purchase_dt : null,
            'original_price' => $data->original_price ? $data->original_price : '-',
            'earlier_maintenance_cost' => $data->earlier_maintenance_cost ? $data->earlier_maintenance_cost : '-',
            'category_name' => $data->hasCategory ? $data->hasCategory->name : '-',
            'subCat_name' => $data->hasSubcategory ? $data->hasSubcategory->name : '-',
            'subCatTy_name' => $data->hasSubCategoryType ? $data->hasSubCategoryType->name : '-',
            'brand_name' => $data->hasVehicleBrand ? $data->hasVehicleBrand->name : '-',
            // 'other_sub_category_type' => $data->other_sub_category_type ? $data->other_sub_category_type : '-',
        ];
        return json_encode($array);
    }

    public function saveForm(Request $request)
    {
        Log::info($request);

        $checkExistFormLvl1 = AssessmentFormCheckLvl1::where([
            'assessment_type_id' => $request->assessment_type_id,
            'vehicle_id' => $request->vehicle_id
        ])->get();

        foreach ($checkExistFormLvl1 as $CheckList){
            Log::info($request['form_check_percentage_lvl1_component_id_'.$CheckList->id]);


                if($request['form_check_percentage_lvl1_component_id_'.$CheckList->id] == null){

                    $validator = Validator::make($request->all(), [
                        'form_note_lvl1_component_id_'.$CheckList->id => 'required',
                    ],
                    [
                        'form_note_lvl1_component_id_'.$CheckList->id.'.required' => 'Sila isikan catatan jika gagal',
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                    }
                }

                // $validator = Validator::make($request->all(), [
                //     'form_check_is_repair_lvl1_component_id_'.$CheckList->id => 'required_without_all:form_check_is_repairs_lvl1_component_id_'.$CheckList->id.'||form_check_is_replacement_lvl1_component_id_'.$CheckList->id,
                //     'form_check_is_repairs_lvl1_component_id_'.$CheckList->id => 'required_without_all:form_check_is_repair_lvl1_component_id_'.$CheckList->id.'||form_check_is_replacement_lvl1_component_id_'.$CheckList->id,
                //     'form_check_is_replacement_lvl1_component_id_'.$CheckList->id => 'required_without_all:form_check_is_repair_lvl1_component_id_'.$CheckList->id.'||form_check_is_repairs_lvl1_component_id_'.$CheckList->id,
                // ],
                // [
                //     'form_check_is_repair_lvl1_component_id_'.$CheckList->id.'.required_without_all' => 'Sila pilih salah satu',
                //     'form_check_is_repairs_lvl1_component_id_'.$CheckList->id.'.required_without_all'  => 'Sila pilih salah satu',
                //     'form_check_is_replacement_lvl1_component_id_'.$CheckList->id.'.required_without_all'  => 'Sila pilih salah satu',
                // ]);

                // if ($validator->fails()) {
                //     return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                // }

                $CheckList->update([
                    'disposal_percentage_id' => $request['form_check_percentage_lvl1_component_id_'.$CheckList->id] ? $this->hasDisposalPercentage($request['form_check_percentage_lvl1_component_id_'.$CheckList->id]) : null,
                    'note' => $request['form_note_lvl1_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id,
                    'is_repair' => $request['form_check_is_repair_lvl1_component_id_'.$CheckList->id],
                    'is_repairs' => $request['form_check_is_repairs_lvl1_component_id_'.$CheckList->id],
                    'is_replacement' => $request['form_check_is_replacement_lvl1_component_id_'.$CheckList->id]
                ]);

            // 'is_replace.required_without_all' => 'Sila pilih salah satu',

        }

        // $stringToReplace = "\n";
        $estimate_value_after = $this->removeNonCurrencydata($request->current_value) + ($this->removeNonCurrencydata($request->current_maintenance_cost) / 2);
        $AssessmentDisposalVehicle = AssessmentDisposalVehicle::find($request->vehicle_id);
        $dataVehicle = [
            'odometer' => $request->odometer ? $request->odometer : $AssessmentDisposalVehicle->odometer,
            'mileage_distance' => $request->mileage_distance ? $request->mileage_distance : 0,
            'hours_used' => $request->hours_used ? $request->hours_used : 0,
            'earlier_maintenance_cost' => $this->removeNonCurrencydata($request->earlier_maintenance_cost ? $request->earlier_maintenance_cost : 0),
            'current_maintenance_cost' => $this->removeNonCurrencydata($request->current_maintenance_cost ? $request->current_maintenance_cost : 0),
            'post_durability' => $request->post_durability ? $request->post_durability : 0,
            'post_current_value' => $this->removeNonCurrencydata($request->post_current_value ? $request->post_current_value : 0),
            'current_value' => $this->removeNonCurrencydata($request->current_value ? $request->current_value : 0),
            'delivery_service' => $request->delivery_service ? $request->delivery_service : 0,
            'evaluation_type' => $request->check_type,
            'estimate_value_after' => $estimate_value_after,
            'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentDisposalVehicle->foremen_by,
            'foremen_dt' => Auth::user()->isForemenAssessment() ? Carbon::now() : $AssessmentDisposalVehicle->foremen_dt,
            'assessment_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentDisposalVehicle->assessment_by,
            'assessment_dt' => Auth::user()->isForemenAssessment() ? Carbon::now() : $AssessmentDisposalVehicle->assessment_dt,
            'verify_by' => Auth::user()->isAssistEngineerAssessment() ? Auth::user()->id : $AssessmentDisposalVehicle->verify_by,
            'verify_dt' => Auth::user()->isAssistEngineerAssessment() ? Carbon::now() : $AssessmentDisposalVehicle->verify_dt,
            'approve_by' => Auth::user()->isEngineerAssessment() ? Auth::user()->id : $AssessmentDisposalVehicle->approve_by,
            'approve_dt' => Auth::user()->isEngineerAssessment() ? Carbon::now() : $AssessmentDisposalVehicle->approve_dt,
            'manual_depreciation' => $request->manual_depreciation ? $request->manual_depreciation : 0,
            'kewpa_remarks' => $request->kewpa_remarks ? str_replace("\n", "<br>",$request->kewpa_remarks) : null,
            'kewpa_remarks2' => $request->kewpa_remarks2 ? str_replace("\n", "<br>",$request->kewpa_remarks2) : null,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'aset_regno' => $request->aset_regno,
            'nc_no' => $request->nc_no,
        ];

        $url = null;
        if($request->save_as != 'draf'){
            $url = route('assessment.disposal.register', ["id"=> Request("assessment_id"), "tab" => 4]);
            if(Auth::user()->isForemenAssessment()){
                $url = route('access.operation.dashboard');
                $AssessmentDisposal = AssessmentDisposal::find($AssessmentDisposalVehicle->assessment_disposal_id);
                    $datadisposal = [
                        'ttl_assess' => $AssessmentDisposal->ttl_assess - 1,
                        'ttl_evaluate' => $AssessmentDisposal->ttl_evaluate + 1,
                    ];
                $AssessmentDisposal->update($datadisposal);
            }
            if($AssessmentDisposalVehicle->hasAssessmentVehicleStatus->code == '03' && auth()->user()->isForemenAssessment()){
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('04');
                $dataVehicle['in_assessment'] = false;
                $examination = AssessmentDisposal::find($AssessmentDisposalVehicle->assessment_disposal_id);
                // $this->sendEmailAssistEngineerNotification($examination);
            }
            if( $AssessmentDisposalVehicle->hasAssessmentVehicleStatus->code == '04' && auth()->user()->isAssistEngineerAssessment()){

                $url = route('assessment.disposal.register', ["id"=> Request("assessment_id"), "tab" => 6]);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('05');
                $AssessmentDisposal = AssessmentDisposal::find($AssessmentDisposalVehicle->assessment_disposal_id);
                    $dataNew = [
                        'ttl_evaluate' => $AssessmentDisposal->ttl_evaluate - 1,
                        'ttl_approve' => $AssessmentDisposal->ttl_approve + 1,
                    ];
                $AssessmentDisposal->update($dataNew);
                // $this->sendEmailEngineerNotification($AssessmentDisposal, $AssessmentDisposalVehicle);
            }
            if( $AssessmentDisposalVehicle->hasAssessmentVehicleStatus->code == '05' && auth()->user()->isEngineerAssessment()){
                $url = route('assessment.disposal.register', ["id"=> Request("assessment_id"), "tab" => 8]);
                // dd($url);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('06');

                $examination = AssessmentDisposal::find(session()->get('disposal_current_detail_id'));

                $this->sendEmailUserNotification($examination, $AssessmentDisposalVehicle);
            }
        }

        $AssessmentDisposalVehicle->update($dataVehicle);
        $examination = AssessmentDisposal::find($AssessmentDisposalVehicle->assessment_disposal_id);

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
            $url = route('assessment.disposal.register', ['id' => session()->get('disposal_current_detail_id'), "tab" => 6]);
        }

        if(auth()->user()->isEngineerAssessment()){

            if($examination->hasUnVerifyVehicle->count() == 0){
                $toUpdate = [
                            'app_status_id' => $this->assessmentStatus('08'),
                        ];
                $examination->update($toUpdate);
            }
            $url = route('assessment.disposal.register', ['id' => session()->get('disposal_current_detail_id'), "tab" => 8]);
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
                $query = AssessmentDisposalVehicle::find($request->id);
                $prevFileId = $query->doc_id;
                $file_id = $this->createDocVeh($request->file, $request->vehicle_id)->id;
                $query->update([
                    'veh_img_doc' => $file_id
                ]);
                break;
            case 'vtl_doc':
                $query = AssessmentDisposalVehicle::find($request->id);
                $prevFileId = $query->doc_id;
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
            case 4:
                $query = AssessmentDisposalVehicle::find($request->vehicle_id);
                $file = $request->file;
                $docFormat = $file->getClientOriginalExtension();
                $fileName = Str::random(9).'.'.$docFormat;

                    if($file != null){
                        $path = 'public/dokumen/assessment/disposal/';

                        $file->storeAs($path, $fileName);
                        $vtl_doc = 'dokumen/assessment/disposal/'.$fileName;
                        $data = [
                            'vtl_doc' => $vtl_doc,
                        ];

                        $query->update($data);
                    }
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

            $path = 'public/dokumen/assessment/disposal/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/disposal/',
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

            $path = 'public/dokumen/assessment/disposal/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/disposal/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' =>$this->hasAssessmentType('06'),
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
        $detail = AssessmentDisposalVehicle::find($request->vehicle_id);
        return [
            'detail' => $detail
        ];
    }

    public function checkGenuine(Request $request){
        $key = $request->key;
        return AssessmentDisposalVehicle::where('cert_hash_key',$key)->first();
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = AssessmentDisposalVehicle::whereIn('id', $ids);
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
        $query = AssessmentDisposalVehicle::whereIn('id', $ids);
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
        Log::info('AssessmentDisposalVehicleDAO :: vehicleStatus');
        Log::info($query);
        return $query;
    }

    public function updateStatus(Request $request){
        Log::info($request);
        $vehicle_id = $request->vehicle_id;
        $vehicle_status_code = $request->status_code;
        $query = AssessmentDisposalVehicle::find($vehicle_id);
        $query->update([
            'assessment_vehicle_status_id' => $this->vehicleStatus($vehicle_status_code)
        ]);
        Log::info($query->toSql());
        Log::info($query->get());
        $check = $query->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '03');
        })->get();
        $total = count($check);

        if($total == 0){
            $url = route('assessment.disposal.register', ["id"=> Request("assessment_id"), "tab" => 7]);
        }else{
            $url = route('assessment.disposal.register', ["id"=> Request("assessment_id"), "tab" => 6]);
        }
        $AssessmentDisposalVehicle = $query->first();
        $AssessmentDisposal = AssessmentDisposal::find($AssessmentDisposalVehicle->assessment_disposal_id);
                    $datadisposal = [
                        'ttl_approve' => $AssessmentDisposal->ttl_approve - 1,
                        'ttl_complete' => $AssessmentDisposal->ttl_complete + 1,
                    ];
            $AssessmentDisposal->update($datadisposal);

        $findVehicle = AssessmentDisposalVehicle::where('assessment_disposal_id', $AssessmentDisposal->id)
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereIn('code', ['01','02','03','06']);
                                            })->get();
        $reassignStatusAssessmentDisposal = count($findVehicle);

        if($reassignStatusAssessmentDisposal == 0){
            $complete = [
                'app_status_id' => $this->assessmentStatus("08")
            ];
            $AssessmentDisposal->update($complete);
        }
        $response = [
            'code' => 200,
            'url' => $url,
            'message' => 'Maklumat berjaya dikemaskini',
        ];

        Log::info($response);
        return $response;
    }

    public function getCertificateDetails(Request $request){
        $vehicleId = $request->vehicleId;

        Session::put('session_disposal_vehicle_id', $vehicleId);

        $data = AssessmentDisposalVehicle::select(
            'id', 
            'plate_no', 
            'earlier_maintenance_cost',
            'current_maintenance_cost',
            'purchase_dt',
            'original_price',
        )->find($vehicleId);
        return $data;
    }

    public function editCertificateSave(Request $request){

        $vehicleId = null;

        if(Session::get('session_disposal_vehicle_id')){
            $vehicleId = Session::get('session_disposal_vehicle_id');
        }

        $data = AssessmentDisposalVehicle::find($vehicleId);

        $dataVehicle = [];
        $message = "";

        if($data){

            if($request->plate_no){
                $dataVehicle['plate_no'] = $request->plate_no;
            }

            if($request->purchase_dt){
                $dataVehicle['purchase_dt'] = $request->purchase_dt;
            }

            if($request->original_price){
                $dataVehicle['original_price'] = str_replace(',','', $request->original_price);
            }

            if($request->earlier_maintenance_cost){
                $dataVehicle['earlier_maintenance_cost'] = str_replace(',','', $request->earlier_maintenance_cost);
            }

            try {
                $data->update($dataVehicle);
                $message = 'Maklumat Berjaya Disimpan';
            } catch (\Throwable $th) {
                $message = 'Maklumat Tidak Berjaya Disimpan';
            }
            
        }

        Session::put('session_disposal_vehicle_id', null);
        
        $response = [
            'code' => 200,
            'message' =>  $message,
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    private function sendEmailAssistEngineerNotification($examination){

        $emailBody = [
            'title' => 'Pengesahan Penilaian Pelupusan',
            'subject' => 'Pengesahan Penilaian Pelupusan '.Carbon::now()->format('d/m/Y'),
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

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentDisposalVehicleStatusAssisstEngineer($emailBody));
    }

    private function sendEmailEngineerNotification($examination, $AssessmentDisposalVehicle){
        $emailBody = [
            'title' => 'Semakan Penilaian Pelupusan',
            'subject' => 'Semakan Penilaian Pelupusan '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'plate_no' => $AssessmentDisposalVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentDisposalVehicleStatusEngineer($emailBody));
    }

    private function sendEmailUserNotification($examination, $AssessmentDisposalVehicle){

        $emailBody = [
            'title' => 'KEW.PA-19',
            'subject' => 'KEW.PA-19 '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'appointment_dt' => $examination->appointment_dt,
            'vehicle_id' => $AssessmentDisposalVehicle->id,
            'plate_no' => $AssessmentDisposalVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentDisposalVehicleStatusAssisstUser($emailBody));
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function hasAssessmentVehicleStatus($code){
        $data = AssessmentVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    private function hasDisposalPercentage($code){

        $data = AssessmentDisposalPercentage::where('code', $code)->first();
        return $data->id;
    }

    public function assessmentStatus($code)
    {
        $status = AssessmentApplicationStatus::where('code',$code)->first();
        return $status->id;
    }

    private function removeNonCurrencydata($curreny){

        $new_curreny = preg_replace('/,/', '', $curreny);

        return $new_curreny;
    }

    public function hasAssessmentType($code)
    {
        $type = AssessmentType::where('code', $code)->first();
        return $type->id;
    }
}
