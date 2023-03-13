<?php

namespace App\Http\Controllers\Assessment\Currvalue\Vehicle;

use App\Http\Controllers\Assessment\Currvalue\AssessmentCurrvalueDAO;
use App\Mail\module\assessment\currvalue\SendEmailToUserAssessmentCurrvalueVehicleStatusAssisstEngineer;
use App\Mail\module\assessment\currvalue\SendEmailToUserAssessmentCurrvalueVehicleStatusAssisstUser;
use App\Mail\module\assessment\currvalue\SendEmailToUserAssessmentCurrvalueVehicleStatusEngineer;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentFormCheckDoc;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentCurrvalueVehicle;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use App\Models\Assessment\AssessmentFormCheckLvl3;
use App\Models\Assessment\AssessmentCurrvalueFormCheckDoc;
use App\Models\Assessment\AssessmentType;
use App\Models\Assessment\AssessmentVehicleImage;
use App\Models\Assessment\AssessmentVehicleStatus;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\RefEvent;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Undefined;

use function GuzzleHttp\Promise\all;

class AssessmentCurrvalueVehicleDAO
{
    public $id = -1;
    public $detail;
    public $message;

    public function list()
    {
        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $data = AssessmentCurrvalueVehicle::where('assessment_currvalue_id', $assessment_currvalue_id)
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
        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $data = AssessmentCurrvalueVehicle::where('assessment_currvalue_id', $assessment_currvalue_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00','01']);
        });

        $totalPrice = $data->sum('vehicle_price');

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

        // return $data->orderBy('created_at','desc')->paginate(5);
    }

    public function foremenList(){
        $query = User::whereHas('roles', function($q){
            $q->where('name', '07');
        })->whereHas('detail', function($q){
            $queryAssessmentCurrvalueDetail = AssessmentCurrvalue::find(session()->get('currvalue_current_detail_id'));
            $q->where('workshop_id', $queryAssessmentCurrvalueDetail->hasWorkShop->id)
            ->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        });
        return $query->get();
    }

    public function updatePrice(Request $request){
        $query = AssessmentCurrvalueVehicle::find($request->vehicle_id);
        $query->update([
            'vehicle_price' => $request->price
        ]);
    }

    public function assignToFormen(Request $request){
        $query = AssessmentCurrvalueVehicle::find($request->vehicle_id);
        $query->update([
            'foremen_by' => $request->user_id
        ]);
    }

    public function read()
    {
        $this->detail = AssessmentCurrvalueVehicle::find($this->id);
    }

    public function upsert(Request $request)
    {
        if($request->assessment_currvalue_id){
            session()->put('currvalue_current_detail_id', $request->assessment_currvalue_id);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'sub_category_id' => 'required_with:category_id',
            'plate_no' => 'required',
            'engine_no' => 'required',
            'chasis_no' => 'required',
            'vehicle_brand_id' => 'required',
            'model_name' => 'required',
            'manufacture_year' => 'required_without:has_no_year_manufactured',
            'registration_vehicle_dt' => 'required_without:has_no_year_manufactured',
        ],
        [
            'category_id.required' => 'Sila Pilih Kategori Kenderaan',
            'sub_category_id.required_with' => 'Sila Pilih Sub Kategori Kenderaan',
            'plate_no.required' => 'Sila Masukkan No Pendaftaran',
            'engine_no.required' => 'Sila Masukkan No Enjin',
            'chasis_no.required' => 'Sila Masukkan No Chasis',
            'vehicle_brand_id.required' => 'Sila Pilih Buatan',
            'model_name.required' => 'Sila Masukkan Model',
            'manufacture_year.required_without' => 'Sila Pilih Tahun Dibuat',
            'registration_vehicle_dt.required_without' => 'Sila Pilih Tarikh Pendaftaran',
        ]);

        $hasChildVSubCat = RefSubCategory::where([
            'category_id' => $request->category_id,
            'status' => 1
        ])->count();

        $hasChildVType = RefSubCategoryType::where([
            'sub_category_id' => $request->sub_category_id,
            'status' => 1
        ])->count();

        Log::info('hasChildVType =>' .$hasChildVType);

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
        if($request->has_no_year_manufactured){
            Log::info("atas");
            $dataVehicle = [
                'assessment_currvalue_id' => session()->get('currvalue_current_detail_id'),
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sub_category_type_id' => $request->sub_category_type_id,
                'plate_no' => $request->plate_no,
                'engine_no' => $request->engine_no,
                'chasis_no' => $request->chasis_no,
                'vehicle_brand_id' => $request->vehicle_brand_id,
                'model_name' => $request->model_name,
                'manufacture_year' => null,
                'registration_vehicle_dt' => null,
                'applicant_company' => $request->applicant_company,
                'market_price' => $request->market_price ? preg_replace('/,/', '', $request->market_price) : 0.00,
                'original_price' => $request->original_price ? preg_replace('/,/', '', $request->original_price) : 0.00,
                'is_move' => $request->is_move ? true : false,
                'location' => $request->location,
                'has_no_year_manufactured' => $request->has_no_year_manufactured,
            ];
            
        }
        else{
            Log::info("bawah");
            $dataVehicle = [
                'assessment_currvalue_id' => session()->get('currvalue_current_detail_id'),
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sub_category_type_id' => $request->sub_category_type_id,
                'plate_no' => $request->plate_no,
                'engine_no' => $request->engine_no,
                'chasis_no' => $request->chasis_no,
                'vehicle_brand_id' => $request->vehicle_brand_id,
                'model_name' => $request->model_name,
                'manufacture_year' => $request->manufacture_year,
                'registration_vehicle_dt' => $request->registration_vehicle_dt,
                'applicant_company' => $request->applicant_company,
                'market_price' => $request->market_price ? preg_replace('/,/', '', $request->market_price) : 0.00,
                'original_price' => $request->original_price ? preg_replace('/,/', '', $request->original_price) : 0.00,
                'is_move' => $request->is_move ? true : false,
                'location' => $request->location,
                'has_no_year_manufactured' => $request->has_no_year_manufactured,
            ];
        }

        $this->detail = AssessmentCurrvalueVehicle::find($request->assessment_vehicle_id);

        Log::info(session()->get('currvalue_current_detail_id'));

        $AssessmentCurrvalue = AssessmentCurrvalue::find(session()->get('currvalue_current_detail_id'));

        Log::info("message");

        if($this->detail){
            // $dataVehicle['registration_vehicle_dt'] = $request->registration_vehicle_dt;
            $dataVehicle['updated_by'] =  Auth::user()->id;
            $query = $this->detail->update($dataVehicle);
            $this->message = 'Maklumat Berjaya Dikemaskini';
        } else {

            $dataVehicle['assessment_vehicle_status_id'] = $this->hasAssessmentVehicleStatus("01");

            $assessmentCurrvalueVehicleId = session()->get('assessment_currvalue_vehicle_id');
            $checkIsExisted = FleetDepartment::find($assessmentCurrvalueVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $assessmentCurrvalueVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;
            $query = AssessmentCurrvalueVehicle::create($dataVehicle);
            $data = [
                'ttl_draf' =>  $AssessmentCurrvalue->ttl_draf + 1,
                'ttl_vehicle' =>  $AssessmentCurrvalue->ttl_vehicle + 1,
            ];
            $AssessmentCurrvalue->update($data);
            $this->message = 'Maklumat Berjaya Ditambah';
        }

        $AssessmentCurrvalue = AssessmentCurrvalue::find(session()->get('currvalue_current_detail_id'));

        $response = [
            'query' => $query,
            'code' => 200,
            'total_vehicle' => $AssessmentCurrvalue->hasVehicle->count(),
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
        return [
            'AssessmentFormCheckLvl1List' => $AssessmentFormCheckLvl1List->get()
        ];
    }

    public function getVehicleForm(Request $request)
    {

        $vehicleId = $request->vehicleId;
        $data = AssessmentCurrvalueVehicle::find($vehicleId);
        $array = [
            'id' => $data->id,
            'assessment_currvalue_id' => $data->assessment_currvalue_id ? : '-',
            'category_id' => $data->category_id ? $data->category_id : '-',
            'sub_category_id' => $data->sub_category_id ? $data->sub_category_id : '-',
            'sub_category_type_id' => $data->sub_category_type_id ? $data->sub_category_type_id : '-',
            'subcategory_type' => $data->hasSubCategoryType ? $data->hasSubCategoryType->name : '-',
            'vehicle_brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'purchase_dt' => $data->purchase_dt ? $data->purchase_dt : null,
            'company_name' => $data->company_name ? $data->company_name : '-',
            'lo_no' => $data->lo_no ? $data->lo_no : '-',
            'is_gover' => $data->is_gover ? $data->is_gover : '-',
            'plate_no' => $data->plate_no ? $data->plate_no : '-',
            'engine_no' => $data->engine_no ? $data->engine_no : '-',
            'chasis_no' => $data->chasis_no ? $data->chasis_no : '-',
            'brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
            'model_name' => $data->model_name ? $data->model_name : '-',
            'manufacture_year' => $data->manufacture_year ? $data->manufacture_year : null,
            'registration_vehicle_dt' => $data->registration_vehicle_dt ? $data->registration_vehicle_dt : null,
            'applicant_name' => $data->applicant_name ? $data->applicant_name : '-',
            'applicant_ic_no' => $data->applicant_ic_no ? $data->applicant_ic_no : '-',
            'applicant_company' => $data->applicant_company ? $data->applicant_company : '-',
            'original_price' => $data->original_price ? $data->original_price : '-',
            'market_price' => $data->market_price ? $data->market_price : '-',
            'applicant_ic_no' => $data->applicant_ic_no ? $data->applicant_ic_no : '-',
            'category_name' => $data->hasCategory ? $data->hasCategory->name : '-',
            'subCat_name' => $data->hasSubcategory ? $data->hasSubcategory->name : '-',
            'subCatTy_name' => $data->hasSubCategoryType ? $data->hasSubCategoryType->name : '-',
            'brand_name' => $data->hasVehicleBrand ? $data->hasVehicleBrand->name : '-',
            'is_move' => $data->is_move,
            'location' => $data->location,
            'has_no_year_manufactured' => $data->has_no_year_manufactured,
        ];
        return json_encode($array);
    }
//
    public function saveFormCurrvalue(Request $request)
    {
        // dd($request->all());
        $AssessmentFormCheckLvl1 = AssessmentFormCheckLvl1::find($request->check_lvl_id);
        $data = [
            'engine_system' => $request->engine_system,
            'engine_system_check' => $request->engine_system_check ? true : false,
            'trans_system_check' => $request ->trans_system_check ? true : false,
            'susp_system_check' => $request ->susp_system_check ? true : false,
            'brek_system_check' => $request->brek_system_check ? true : false,
            'wiring_system_check' => $request->wiring_system_check ? true : false,
            'aircond_system_check' => $request->aircond_system_check ? true : false,
            'odo_read' => $request->odo_read,
            'fuel_type_id' => $request->fuel_type_id,
            'bottom_part_cond' => $request->bottom_part_cond,
            'inner_part_cond' => $request->inner_part_cond,
            'outer_part_cond' => $request->outer_part_cond,
            'trans_system' => $request->trans_system,
            'susp_system' => $request->susp_system,
            'brek_system' => $request->brek_system,
            'wiring_system' => $request->wiring_system,
            'aircond_system' => $request->aircond_system,
            'tyre_year_fl' => $request->tyre_year_fl,

            // 'tyre_year_rl' => $request->tyre_year_rl,
            // 'tyre_year_fr' => $request->tyre_year_fr,
            // 'tyre_year_rr' => $request->tyre_year_rr,
            'total_seat' => $request->total_seat,
            'transmission' => $request->transmission == "undefined" ? null : $request->transmission,
            'wheel_type' => $request->wheel_type == "undefined" ? null : $request->wheel_type,
            'tyre_front_left_percentage' => $request->tyre_front_left == "undefined" ? 0 : $request->tyre_front_left,
            // 'tyre_back_left_percentage' => $request->tyre_back_left == "undefined" ? 0 : $request->tyre_back_left,
            // 'tyre_front_right_percentage' => $request->tyre_front_right == "undefined" ? 0 : $request->tyre_front_right,
            // 'tyre_back_right_percentage' => $request->tyre_back_right == "undefined" ? 0 : $request->tyre_back_right,
            'receipt_no' => $request->receipt_no,
            'evaluation_type' => $request->check_type,
            'accessories_detail' => $request->accessories_detail
        ];

        $url = null;
        $AssessmentCurrvalueVehicle = AssessmentCurrvalueVehicle::find($request->vehicle_id);

        // {{auth()->user()->isAssistEngineerAssessment() || auth()->user()->isAssistEngineer() || auth()->user()->isEngineerAssessment() || auth()->user()->isEngineer()
        if(auth()->user()->isAssistEngineerAssessment()){

            $requiredField = [
                'checkEvaType' => 'required',
            ];

            $requiredMessage = [
                'checkEvaType.required' => 'Sila pilih kaedah penilaian',
            ];

            if($request->checkEvaType) {
                switch ($request->checkEvaType) {
                    case 1:
                        $requiredField['estimate_repair'] = 'not_in:0';
                        $requiredField['estimate_price'] = 'not_in:0';

                        $requiredMessage['estimate_repair.not_in'] = 'Sila isikan anggaran pembaikan';
                        $requiredMessage['estimate_price.not_in'] = 'Sila isikan harga anggaran';

                        break;

                    case 2:
                        $requiredField['estimate_repair'] = 'not_in:0';
                        $requiredField['estimate_price'] = 'not_in:0';

                        $requiredMessage['estimate_repair.not_in'] = 'Sila isikan anggaran pembaikan';
                        $requiredMessage['estimate_price.not_in'] = 'Sila isikan harga anggaran';

                        break;
                    case 3:
                        $requiredField['metal_price'] = 'not_in:0';
                        $requiredField['metal_weight'] = 'not_in:0';

                        $requiredMessage['metal_price.not_in'] = 'Sila isikan harga besi';
                        $requiredMessage['metal_weight.not_in'] = 'Sila isikan berat besi';

                        break;

                    case 4:
                        $requiredField['metal_price'] = 'not_in:0';
                        $requiredField['metal_weight'] = 'not_in:0';

                        $requiredMessage['metal_price.not_in'] = 'Sila isikan harga besi';
                        $requiredMessage['metal_weight.not_in'] = 'Sila isikan berat besi';

                        break;
                    
                    default:
                        # code...
                        break;
                }
            }

            $request->validate($requiredField, $requiredMessage);
        }
        
        $dataVehicle = [
            'original_price' => $request->original_price ? preg_replace('/,/', '', $request->original_price,) : 0,
            'current_price'=> $request->current_price ? round(preg_replace('/,/', '', $request->current_price), 0): 0,
            'market_price'=> $request->market_price ? preg_replace('/,/', '', $request->market_price) : 0,
            'estimate_repair'=> $request->estimate_repair ? preg_replace('/,/', '', $request->estimate_repair) : 0,
            'estimate_price'=> $request->estimate_price ? preg_replace('/,/', '', $request->estimate_price) : 0,
            'durabilty'=> $request->durabilty,
            'evaluation_type' => $request->check_type,
            'odometer' => $request->odo_read,
            'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentCurrvalueVehicle->foremen_by,
            'foremen_dt' => Auth::user()->isForemenAssessment() ? Carbon::now(): $AssessmentCurrvalueVehicle->foremen_dt,
            'assessment_dt' => Auth::user()->isForemenAssessment() ? Carbon::now() : $AssessmentCurrvalueVehicle->assessment_dt,
            'assessment_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : $AssessmentCurrvalueVehicle->assessment_by,
            'verify_dt' => Auth::user()->isAssistEngineerAssessment() ? Carbon::now() : $AssessmentCurrvalueVehicle->verify_dt,
            'verify_by' => Auth::user()->isAssistEngineerAssessment() ? Auth::user()->id : $AssessmentCurrvalueVehicle->verify_by,
            'approve_dt' => Auth::user()->isEngineerAssessment() ? Carbon::now() : $AssessmentCurrvalueVehicle->approve_dt,
            'approve_by' => Auth::user()->isEngineerAssessment() ? Auth::user()->id : $AssessmentCurrvalueVehicle->approve_by,
            'evaluation_currvalue_type' => $request->checkEvaType,
            'certificate_title' => $request->certificate_title,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'metal_price' => $request->metal_price ? preg_replace('/,/', '', $request->metal_price,) : 0,
            'metal_weight' => $request->metal_weight  ? preg_replace('/,/', '', $request->metal_weight,) : 0,
        ];

        if($request->save_as != 'draf'){
            $url = route('assessment.currvalue.register', ["id"=> Request("assessment_id"), "tab" => 4]);
            if(Auth::user()->isForemenAssessment()){
                $url = route('access.operation.dashboard');
                $AssessmentCurrvalue = AssessmentCurrvalue::find($AssessmentCurrvalueVehicle->assessment_currvalue_id);
                    $dataNew = [
                        'ttl_assess' => $AssessmentCurrvalue->ttl_assess - 1,
                        'ttl_evaluate' => $AssessmentCurrvalue->ttl_evaluate + 1,
                    ];
                $AssessmentCurrvalue->update($dataNew);
            }
            if($AssessmentCurrvalueVehicle->hasAssessmentVehicleStatus->code == '03' && auth()->user()->isForemenAssessment()){
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('04');
                $dataVehicle['in_assessment'] = false;
                $examination = AssessmentCurrvalue::find($AssessmentCurrvalueVehicle->assessment_currvalue_id);
                // $this->sendEmailAssistEngineerNotification($examination);
            }
            if( $AssessmentCurrvalueVehicle->hasAssessmentVehicleStatus->code == '04' && auth()->user()->isAssistEngineerAssessment()){
                $url = route('assessment.currvalue.register', ["id"=> Request("assessment_id"), "tab" => 6]);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('05');
                $AssessmentCurrvalue = AssessmentCurrvalue::find($AssessmentCurrvalueVehicle->assessment_currvalue_id);
                    $dataNew = [
                        'ttl_evaluate' => $AssessmentCurrvalue->ttl_evaluate - 1,
                        'ttl_approve' => $AssessmentCurrvalue->ttl_approve + 1,
                    ];
                $AssessmentCurrvalue->update($dataNew);


                // $this->sendEmailEngineerNotification($AssessmentCurrvalue, $AssessmentCurrvalueVehicle);
            }
            if( $AssessmentCurrvalueVehicle->hasAssessmentVehicleStatus->code == '05' && auth()->user()->isEngineerAssessment()){
                $url = route('assessment.currvalue.register', ["id"=> Request("assessment_id"), "tab" => 8]);
                $dataVehicle['assessment_vehicle_status_id'] = $this->vehicleStatus('06');
                $examination = AssessmentCurrvalue::find(session()->get('currvalue_current_detail_id'));
                $dataVehicle['cert_hash_key'] = Str::random(40);
                $totalApprovedV = $examination->hasManyApprovedVehicle->count()+1;
                $generateRefVNumber = $examination->ref_number.'-'.$totalApprovedV;
                $dataVehicle['cert_ref_number'] = $generateRefVNumber;
                $this->sendEmailUserNotification($examination, $AssessmentCurrvalueVehicle);
            }
        }

        $AssessmentCurrvalueVehicle->update($dataVehicle);
        $examination = AssessmentCurrvalue::find($AssessmentCurrvalueVehicle->assessment_currvalue_id);

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
            $url = route('assessment.currvalue.register', ['id' => session()->get('currvalue_current_detail_id'), "tab" => 6, 'prev_page' => $request->prev_page]);
        }

        if(auth()->user()->isEngineerAssessment()){

            if($examination->hasUnVerifyVehicle->count() == 0){
                $toUpdate = [
                            'app_status_id' => $this->assessmentStatus('08'),
                        ];
                $examination->update($toUpdate);
            }
            $url = route('assessment.currvalue.register', ['id' => session()->get('currvalue_current_detail_id'), "tab" => 7, 'prev_page' => $request->prev_page]);
        }

        $AssessmentFormCheckLvl1->update($data);
        $response = [
            'code' => 200,
            'url' => $url,
            'message' => 'Maklumat semakan kenderaan berjaya dikemaskini'
        ];
        Log::info($response);
        return $response;
    }

    public function saveFormFile(Request $request){
        // dd($request->all());
        switch ($request->lvl) {
            case 'receipt_doc':
                $query = AssessmentCurrvalue::find($request->id);
                $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
                $prevFileId = $query->receipt_doc;
                $query->update([
                    'receipt_doc' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
            case 'vehicle_doc':
                // $query = AssessmentFormCheckLvl1::find($request->check_lvl_id);
                // $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
                // $prevFileId = $query->vehicle_doc;
                // $query->update([
                //     'vehicle_doc' => $file_id
                // ]);
                // $this->deletePrevDoc($prevFileId);
                // break;
                $query = AssessmentCurrvalueVehicle::find($request->id);
                $prevFileId = $query->doc_id;
                $file_id = $this->createDocVeh($request->file, $request->vehicle_id)->id;
                // $query->update([
                //     'veh_img_doc' => $file_id
                // ]);
                break;
            case 'vtl_doc':
                $query = AssessmentFormCheckLvl1::find($request->check_lvl_id);
                $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
                $prevFileId = $query->vtl_doc;
                $query->update([
                    'vtl_doc' => $file_id
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

            $path = 'public/dokumen/assessment/disposal/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/disposal/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' => 5,
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

            $path = 'public/dokumen/assessment/currvalue/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/currvalue/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' =>$this->hasAssessmentType('04'),
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
            case "receipt_doc":
                $query = AssessmentCurrvalue::findOrFail($request->vehicle_id);
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
                $query = AssessmentFormCheckLvl1::findOrFail($request->vehicle_id);
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
        $detail = AssessmentCurrvalueVehicle::find($request->vehicle_id);
        return [
            'detail' => $detail
        ];
    }

    public function checkGenuine(Request $request){
        $key = $request->key;
        return AssessmentCurrvalueVehicle::where('cert_hash_key',$key)->first();
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = AssessmentCurrvalueVehicle::whereIn('id', $ids);
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
        $query = AssessmentCurrvalueVehicle::whereIn('id', $ids);
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
        Log::info('AssessmentCurrvalueVehicleDAO :: vehicleStatus');
        Log::info($query);
        return $query;
    }

    public function updateStatus(Request $request){
        Log::info($request);
        $vehicle_id = $request->vehicle_id;
        $vehicle_status_code = $request->status_code;
        $query = AssessmentCurrvalueVehicle::find($vehicle_id);
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
            'title' => 'Pengesahan Penilaian Harga Semasa',
            'subject' => 'Pengesahan Penilaian Harga Semasa '.Carbon::now()->format('d/m/Y'),
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

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentCurrvalueVehicleStatusAssisstEngineer($emailBody));
    }

    private function sendEmailEngineerNotification($examination, $AssessmentCurrvalueVehicle){
        $emailBody = [
            'title' => 'Semakan Penilaian Harga Semasa',
            'subject' => 'Semakan Penilaian Harga Semasa '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'plate_no' => $AssessmentCurrvalueVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentCurrvalueVehicleStatusEngineer($emailBody));
    }

    private function sendEmailUserNotification($examination, $AssessmentCurrvalueVehicle){

        $emailBody = [
            'title' => 'Sijil Harga Semasa',
            'subject' => 'Sijil Harga Semasa '.Carbon::now()->format('d/m/Y'),
            'assessment_id' => $examination->id,
            'no_rujukan' => $examination->ref_number,
            'worksyop' => $examination->hasWorkShop->desc,
            'applicant_name' => $examination->applicant_name,
            'appointment_dt' => $examination->appointment_dt,
            'vehicle_id' => $AssessmentCurrvalueVehicle->id,
            'plate_no' => $AssessmentCurrvalueVehicle->plate_no,
        ];
        $userEmail = [$examination->email];
        array_push($userEmail, $examination);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserAssessmentCurrvalueVehicleStatusAssisstUser($emailBody));
    }

    public function getCertificateDetails(Request $request){
        $vehicleId = $request->vehicleId;

        $data = AssessmentCurrvalueVehicle::find($vehicleId);
        $dataAss = AssessmentCurrvalue::find($data->assessment_currvalue_id);
        $array = [
            'id' => $data->id,
            'assessment_currvalue_id' => $data->assessment_currvalue_id ? $data->assessment_currvalue_id : '-',
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
        $data = AssessmentCurrvalueVehicle::find($vehicleId);

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

        $AssessmentCurrvalue = AssessmentCurrvalue::find($data->assessment_currvalue_id);
        $dataAssessment = [
            "hod_title" => $request->ketua_jabatan,
            "department_name" => $request->jabatan_agensi,
        ];

        $queryVehicle = $data->update($dataVehicle);
        $queryAppl = $AssessmentCurrvalue->update($dataAssessment);

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
