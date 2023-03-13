<?php

namespace App\Http\Controllers\Assessment\Accident\Vehicle;

use App\Http\Controllers\Assessment\Accident\AssessmentAccidentDAO;
use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentFormCheckLvl1Selection;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use App\Models\Assessment\AssessmentFormCheckLvl3;
use App\Models\Assessment\AssessmentFormCheckDoc;
use App\Models\Assessment\AssessmentAccidentPercentage;
use App\Models\Assessment\AssessmentAccidentStruckVehicle;
use App\Models\Assessment\AssessmentAccidentVehicleDamageForm;
use App\Models\Assessment\AssessmentApplicationStatus;
use App\Models\Assessment\AssessmentVehicleImage;
use App\Models\Assessment\AssessmentVehicleStatus;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefEvent;
use App\Models\RefSelection;
use App\Models\RefTableSelection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssessmentAccidentVehicleDAO
{
    public $id = -1;
    public $detail;
    public $message;
    public $damage_id = -1;

    public function list()
    {
        $assessment_accident_id = session()->get('accident_current_detail_id');
        $data = AssessmentAccidentVehicle::where('assessment_accident_id', $assessment_accident_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00']);
        });

        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }
        //Log::info($data->first());
        // return $data->get();
        return $data->latest()->paginate(5);
    }

    public function vehicleListFirst()
    {
        $assessment_accident_id = session()->get('accident_current_detail_id');
        $data = AssessmentAccidentVehicle::where('assessment_accident_id', $assessment_accident_id)
        ->whereHas('hasAssessmentVehicleStatus', function ($q){
            $q->whereNotIn('code', ['00']);
        });

        if(auth()->user()->isForemenAssessment()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }
        
        return $data->first();
    }

    public function damageList()
    {
        $assessment_accident_id = session()->get('accident_current_detail_id');
        $assessment_accident_vehicle_id = AssessmentAccidentVehicle::where('assessment_accident_id', $assessment_accident_id)->first();

        $data = AssessmentAccidentVehicleDamageForm::where('assessment_accident_vehicle_id', $assessment_accident_vehicle_id->id);

        // if(auth()->user()->isForemenAssessment()){
        //     $data->whereHas('foremenBy', function($q){
        //         $q->where('id', Auth::user()->id);
        //     });
        // }

        return $data->latest()->paginate(5);
    }

    public function struckList()
    {
        $assessment_accident_id = session()->get('accident_current_detail_id');
        $data = AssessmentAccidentVehicle::where('assessment_accident_id', $assessment_accident_id);
        $check = $data->first();
        if($check){
            $AssessmentAccidentVehicle = $data->first();
            $data = AssessmentAccidentStruckVehicle::where('assessment_accident_vehicle_id', $AssessmentAccidentVehicle->id);
        }

        // if(auth()->user()->isForemenAssessment()){
        //     $data->whereHas('foremenBy', function($q){
        //         $q->where('id', Auth::user()->id);
        //     });
        // }

        return $data->latest()->paginate(5);
    }

    public function foremenList(){
        $query = User::whereHas('roles', function($q){
            $q->where('name', '07');
        })->whereHas('detail', function($q){
            $queryAssessmentAccidentDetail = AssessmentAccident::find(session()->get('accident_current_detail_id'));
            $q->where('workshop_id', $queryAssessmentAccidentDetail->hasWorkShop->id)
            ->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        });
        return $query->get();
    }

    public function assignToFormen(Request $request){
        $query = AssessmentAccidentVehicle::find($request->vehicle_id);
        $query->update([
            'foremen_by' => $request->user_id
        ]);
    }

    public function read()
    {
        $this->detail = AssessmentAccidentVehicle::find($this->id);
    }

    public function upsertForm(Request $request)
    {
        // dd($request->all());
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
        $data = [
            'report_no' => $request->report_no,
            'report_dt' => $request->report_dt,
        ];
        $verify->update($data);
        $response = [
            'query' => $query,
            'code' => 200,
            'message' =>  $this->message,
            'url' => route('assessment.accident.register',[
                'id' => $verify->id,
                'tab' => 2
            ]),
        ];

        Log::info($response);
        unset($response['query']);
        return $response;

    }

    public function upsert(Request $request)
    {
        if($request->assessment_accident_id){
            session()->put('accident_current_detail_id', $request->assessment_accident_id);
        }

        $id = session()->get('struck_vehicle_id') ?: null;

        $validator = Validator::make($request->all(), [
            'accwit_regno' => 'required',
            'vehicle_desc' => 'required',
        ],
        [
            'accwit_regno.required' => 'Sila masukkan no kenderaan terlibat',
            'vehicle_desc.required' => 'Sila isi maklumat berkenaan kenderaan yang terlibat',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dataStruckVehicle = [
            'accwit_regno' => $request->accwit_regno,
            'vehicle_desc' => $request->vehicle_desc,
        ];

        $hasDetail = AssessmentAccidentStruckVehicle::find($id);

        if($hasDetail){
            $AssessmentAccidentStruckVehicle = $hasDetail->update($dataStruckVehicle);
            $this->message = 'Maklumat Berjaya Disimpan';
        } else {
            $AssessmentAccidentVehicle = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'))->first();
            $dataStruckVehicle['assessment_accident_vehicle_id'] = $AssessmentAccidentVehicle->id;
            $dataVehicle['created_by'] =  Auth::user()->id;
            $AssessmentAccidentStruckVehicle = AssessmentAccidentStruckVehicle::create($dataStruckVehicle);
            $this->message = 'Maklumat Berjaya Ditambah';
        }

        $response = [
            'query' => $AssessmentAccidentStruckVehicle,
            'code' => 200,
            'message' =>  $this->message,
        ];
        return $response;
    }

    public function assessmentForemen(Request $request)
    {
        $AssessmentAccident = AssessmentAccident::find($request->assessment_accident_id);
        $AssessmentAccidentVehicle = AssessmentAccidentVehicle::find($request->assessment_accident_vehicle_id);


            $data = [
                'foremen_by' => auth()->user()->id,
                'in_assessment' => true,
            ];
            $AssessmentAccidentVehicle->update($data);


        $response = [
            'url' => route('assessment.accident.register', [
                'id' => $AssessmentAccident->id,
                'tab' => 4
            ])
        ];
            return $response;
    }

    public function informationSave(Request $request){

        $dataInfo = [
            'odometer' => $request->odometer,
            'general_note' => $request->general_note,
        ];

        $AssessmentAccident = AssessmentAccidentVehicle::where('assessment_accident_id', $request->assessment_accident_id)->first();
        $AssessmentAccident->update($dataInfo);
    }

    public function informationSaveFormFile(Request $request){
        $assessment_id = $request->assessment_id;
        $vehicle_id = $request->vehicle_id;
        $this->createDocVeh($request->file, $vehicle_id)->id;
    }

    public function informationDamageImage(Request $request){

        $assessment_id = $request->assessment_id;
        $file_id = $this->createDoc($request->file, $assessment_id)->id;
                $query = AssessmentAccidentVehicleDamageForm::where('assessment_accident_id', $assessment_id)->first();
                $prevFileId = $query->doc_id;
                $query->update([
                    'vehicle_image' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
    }

    public function damageForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'damage' => 'required',
            'is_repair' => 'required_without_all:is_replace',
            'is_replace' => 'required_without_all:is_repair',
            // 'price_list' => 'required',
        ],
        [
            'damage.required' => 'Sila isi maklumat kerosakan',
            'is_repair.required_without_all' => 'Sila pilih salah satu',
            'is_replace.required_without_all' => 'Sila pilih salah satu',
            // 'price_list.required' => 'Sila masukkan kiraan harga',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $damage_id = $request->damage_id ? $request->damage_id : $this->damage_id;
        $AssessmentAccidentVehicleDamageForm = AssessmentAccidentVehicleDamageForm::find($damage_id);

        $data = [
            'damage' => $request->damage,
            'damage_note' => $request->damage_note,
            'is_repair' => $request->is_repair ? $request->is_repair : false,
            'is_replace' => $request->is_replace ? $request->is_replace : false,
            'price_list' => $request->price_list ? preg_replace('/,/', '', $request->price_list) : ($AssessmentAccidentVehicleDamageForm ? $AssessmentAccidentVehicleDamageForm->price_list : null),
            'created_by' => auth()->user()->id,
        ];

        if($request->damage_picture != null){
            $file = $request->damage_picture;
            $docFormat = $file->getClientOriginalExtension();
            $fileName = Str::random(9).'.'.$docFormat;

            if($file != null){

                Log::info($file);
                Log::info($docFormat);

                $path = 'public/dokumen/assessment/accident/';

                $file->storeAs($path, $fileName);

                $damageImage = [
                    'doc_path' => 'dokumen/assessment/accident/',
                    'doc_type' => 'form_file',
                    'doc_format' => $docFormat,
                    'doc_name' => $fileName,
                    'created_by' => auth()->user()->id,
                    'assessment_type_id' => 2,
                ];

                Log::info($damageImage);

                $return_image = AssessmentFormCheckDoc::create($damageImage);
                $data['doc_id'] = $return_image->id;
            }
        }

        $AssessmentAccidentVehicle = AssessmentAccidentVehicle::where('assessment_accident_id', session()->get('accident_current_detail_id'))->first();
        $data['assessment_accident_vehicle_id'] = $AssessmentAccidentVehicle->id;

        if(!$AssessmentAccidentVehicleDamageForm){
            $data['created_by'] = auth()->user()->id;
            $query = AssessmentAccidentVehicleDamageForm::create($data);
            $this->messsage = "Maklumat Berjaya Ditambah";
        }else{
            $data['updated_by'] = auth()->user()->id;
            $query = $AssessmentAccidentVehicleDamageForm->update($data);
            $this->messsage = "Maklumat Berjaya Dikemaskini";
        }

        $response = [
            'query' => $query,
            'code' => 200,
            'message' =>  $this->message,
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function damageCost(Request $request){

        $total_cost_rate = 0;
        $pay_rates = 0;
        $estimate_price = 0;
        $total = 0;
        
        for ($i = 0; $i < count($request->damage_id); $i++) {
            $AssessmentAccidentVehicleDamageForm = AssessmentAccidentVehicleDamageForm::find($request->damage_id[$i]);
            $data = [
                'wages_cost' => preg_replace('/,/', '', $request->wages_cost[$i]),
                'spare_part_price' => preg_replace('/,/', '', $request->spare_part_price[$i]),
                'price_list' => preg_replace('/,/', '', $request->wages_cost[$i]) + preg_replace('/,/', '', $request->spare_part_price[$i]),
            ];

            if($request->section == 'approval'){
                $data['verify_by'] = auth()->user()->id;
            }else{
                $data['approve_by'] = auth()->user()->id;
            }
            $total_cost_rate += (preg_replace('/,/', '', $request->wages_cost[$i]) + preg_replace('/,/', '', $request->spare_part_price[$i]));
            $pay_rates += (preg_replace('/,/', '', $request->wages_cost[$i]) + preg_replace('/,/', '', $request->spare_part_price[$i]));
            $save = $AssessmentAccidentVehicleDamageForm->update($data);
            $assessment_accident_vehicle_id = $AssessmentAccidentVehicleDamageForm->assessment_accident_vehicle_id;
        }
        
        $AssessmentAccidentVehicle = AssessmentAccidentVehicle::find($assessment_accident_vehicle_id);

        foreach ($AssessmentAccidentVehicle->hasVehicleDamageForm as $index => $damage) {
            $estimate_price += ($damage->wages_cost + $damage->spare_part_price);
            $total += ($damage->wages_cost + $damage->spare_part_price);
        }

        $total = $estimate_price;
        $estimate_price = round($estimate_price, -1);

        $dataVehicle = [
            'pay_rates' => $pay_rates,
            // 'estimate_price' => $estimate_price,
            'total' => $total,
            'total_cost_rate' => $total_cost_rate,
            'given_value' => true,
        ];
        if($request->section == 'approval'){
            $dataVehicle['assessment_by'] = auth()->user()->id;
            $dataVehicle['assessment_dt'] = Carbon::now();
        }else{
            $dataVehicle['verify_by'] = auth()->user()->id;
            $dataVehicle['verify_dt'] = Carbon::now();
        }

        $AssessmentAccidentVehicle->update($dataVehicle);

        if($request->save_as == "approval"){
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
            return [
                // 'url' => route('assessment.accident.list')
                'url' => route('assessment.accident.register', [
                    'id' => $request->assessment_id,
                    'tab' => 6
                ])
            ];
        }elseif($request->save_as == "approve"){
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
            return [
                'code' => 200,
                'message' => 'Maklumat kemalangan berjaya dikemaskini',
                'url' => route('assessment.accident.register', [
                    'id' => $request->assessment_id,
                    'tab' => 6
                ])
            ];
        }else{
            $response = [
                'code' => 200,
                'message' => 'Maklumat kemalangan berjaya dikemaskini',
                'url' => route('assessment.accident.register', [
                    'id' => $request->assessment_id,
                    'tab' => 5
                ])
            ];


            Log::info($response);

            return $response;
        }
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

        $vehicleId = $request->vehicleId;

        if($request->type == 'struck'){
            $data = AssessmentAccidentStruckVehicle::find($vehicleId);

            if($data){
                session()->put('struck_vehicle_id', $data->id);
            }

            $array = [
                'id' => $data->id,
                'assessment_accident_id' => $data->assessment_accident_id ? $data->assessment_accident_id : '-',
                'category_id' => $data->category_id ? $data->category_id : '-',
                'sub_category_id' => $data->sub_category_id ? $data-> sub_category_id: '-',
                'sub_category_type_id' => $data->sub_category_type_id ? $data->sub_category_type_id : '-',
                'vehicle_brand_id' => $data->vehicle_brand_id ? $data->vehicle_brand_id : '-',
                'purchase_dt' => $data->purchase_dt ? $data->purchase_dt : null,
                'company_name' => $data->company_name ? $data->company_name : '-',
                'lo_no' => $data->lo_no ? $data->lo_no : '-',
                'is_gover' => $data->is_gover ? $data->is_gover : '-',
                'accwit_regno' => $data->accwit_regno ? $data->accwit_regno : '',
                'vehicle_desc' => $data->vehicle_desc ? $data->vehicle_desc : '',
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

        } else {
            $data = AssessmentAccidentVehicle::find($vehicleId);

            $array = [
                'id' => $data->id,
                'assessment_accident_id' => $data->assessment_accident_id ? $data->assessment_accident_id : '-',
                'category_id' => $data->category_id ? $data->category_id : '-',
                'sub_category_id' => $data->sub_category_id ? $data-> sub_category_id: '-',
                'sub_category_type_id' => $data->sub_category_type_id ? $data->sub_category_type_id : '-',
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
                'manufacture_year' => $data->manufacture_year ? $data->manufacture_year : '-',
                'registration_vehicle_dt' => $data->registration_vehicle_dt ? $data->registration_vehicle_dt : null,
                'category_name' => $data->hasCategory ? $data->hasCategory->name : '-',
                'subCat_name' => $data->hasSubcategory ? $data->hasSubcategory->name : '-',
                'subCatTy_name' => $data->hasSubCategoryType ? $data->hasSubCategoryType->name : '-',
                'brand_name' => $data->hasVehicleBrand ? $data->hasVehicleBrand->name : '-',
            ];
            
        }

        return json_encode($array);
    }

    public function getStruckVehicleForm(Request $request)
    {

        $vehicleId = $request->vehicleId;
        // $data = AssessmentAccidentStruckVehicle::find($vehicleId);
        // $array = [
        //     'id' => $data->id,
        //     'accwit_regno' => $data->accwit_regno,
        //     'vehicle_desc' => $data->vehicle_desc,
        // ];
        $list['struckList'] = AssessmentAccidentStruckVehicle::where('assessment_accident_vehicle_id', $vehicleId)->get();
        return json_encode($list);
    }

    public function getDamageForm(Request $request)
    {

        $damageID = $request->damageID;
        $data['list'] = AssessmentAccidentVehicleDamageForm::find($damageID);

        return json_encode($data);
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
            if($request['form_check_percentage_lvl1_component_id_'.$CheckList->id]){
                $CheckList->update([
                    'accident_percentage_id' => $this->hasAccidentPercentage($request['form_check_percentage_lvl1_component_id_'.$CheckList->id]),
                    'note' => $request['form_note_lvl1_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id,
                    'is_repair' => $request['form_check_is_repair_lvl1_component_id_'.$CheckList->id],
                    'is_replacement' => $request['form_check_is_replacement_lvl1_component_id_'.$CheckList->id]
                ]);
            }
        }

        $data = [
            'foremen_by' => Auth::user()->isForemenAssessment() ? Auth::user()->id : null,
            'verify_by' => Auth::user()->id
        ];

        $AssessmentAccidentVehicle = AssessmentAccidentVehicle::find($request->vehicle_id);

        $url = null;
        if($request->save_as != 'draf'){

            $url = route('assessment.accident.register', ["id"=> Request("assessment_id"), "tab" => 4]);
            if(Auth::user()->isForemenAssessment()){
                $url = route('access.operation.dashboard');
            }
            if($AssessmentAccidentVehicle->hasAssessmentVehicleStatus->code == '02'){
                $data['assessment_vehicle_status_id'] = $this->vehicleStatus('03');
            }
        }

        $AssessmentAccidentVehicle->update($data);

        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        $hasUnVerifyVehicle = $AssessmentAccidentVehicle->hasAssessmentDetail->hasUnVerifyVehicle->count();
        $hasActiveVerifyVehicle = $AssessmentAccidentVehicle->hasAssessmentDetail->hasActiveVerifyVehicle->count();
        Log::info('total hasActiveVerifyVehicle '.$hasActiveVerifyVehicle);

        if($hasActiveVerifyVehicle == 0 && $hasUnVerifyVehicle == 0){

            $AssessmentAccidentVehicle->hasAssessmentDetail->update([
                'app_status_id' => $AssessmentAccidentDAO->assessmentStatus('04')
            ]);

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
                $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
                $prevFileId = $query->doc_id;
                $query->update([
                    'doc_id' => $file_id
                ]);
                $this->deletePrevDoc($prevFileId);
                break;
            case 3:
                $query = AssessmentFormCheckLvl3::find($request->id);
                $file_id = $this->createDoc($request->file, $request->vehicle_id)->id;
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

    private function createDoc($file, $ref_id){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/assessment/accident/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/accident/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' => 2,
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

            $path = 'public/dokumen/assessment/accident/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => 'dokumen/assessment/accident/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'assessment_type_id' => 3,
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

    private function deletePrevDocVeh($id){
        Log::info('file_id => '.$id);

    }

    public function deleteVehiclePicture(Request $request){
        switch ($request->section) {
            case "owner":
                $query = AssessmentVehicleImage::findOrFail($request->image_id);
                    if($query){
                        $query->delete();
                        $path = storage_path().'/'.$query->doc_path.$query->doc_name;
                        Storage::delete($path);
                    }
                break;
            case "struck":
                $query = AssessmentAccidentVehicle::find($request->vehicle_id);
                $query = AssessmentFormCheckDoc::find($query->vehicle_image);
                if($query){
                    // $query->delete();
                    // $path = public_path().'/storage/'.$query->doc_path.$query->doc_name;
                    // unlink($path);
                    // flush();
                    $query->delete();
                    $path = storage_path().'/'.$query->doc_path.$query->doc_name;
                    Storage::delete($path);
                }
                break;
        }

        $response = [
            'code' => 200,
            'message' => 'Gambar berjaya dipadam'
        ];
        return $response;
    }

    public function deleteVehicleDamageForm(Request $request){
        $ids = $request->ids;
        $query = AssessmentAccidentVehicleDamageForm::whereIn('id', $ids);
        $totalChild = $query->count();
        $totalUpdated = 0;

        foreach ($query->get() as $index => $key) {

            $sql = 'UPDATE "assessment"."assessment_accident_vehicle" 
            SET 
            total = total - '.$key->price_list.',
            total_cost_rate = total_cost_rate - '.$key->price_list.',
            pay_rates = pay_rates - '.$key->price_list.'
            WHERE "id" = '.$key->hasAccidentVehicle->id;
            DB::select($sql);

            $getLatest = AssessmentAccidentVehicle::find($key->hasAccidentVehicle->id);

            Log::info($getLatest->total);

            $key->hasAccidentVehicle->update([
                'estimate_price' => round($getLatest->total, -1)
            ]);

            $totalUpdated++;
        };

        if($totalChild == $totalUpdated){
            $query->delete();
        }

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

    public function viewCertificate(Request $request){
        $detail = AssessmentAccidentVehicle::find($request->vehicle_id);
        return [
            'detail' => $detail
        ];
    }

    public function checkGenuine(Request $request){
        $key = $request->key;
        return AssessmentAccidentVehicle::where('cert_hash_key',$key)->first();
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);

        switch ($request->del_type) {
            case 'struck':
                $query = AssessmentAccidentStruckVehicle::whereIn('id', $ids);
                break;
            
            default:
                $query = AssessmentAccidentVehicle::whereIn('id', $ids);
                break;
        }

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

    private function vehicleStatus($code){
        Log::info($code);
        $query = AssessmentVehicleStatus::where('code', $code)->first()->id;
        Log::info('AssessmentAccidentVehicleDAO :: vehicleStatus');
        Log::info($query);
        return $query;
    }

    public function updateStatus(Request $request){
        Log::info($request);
        $vehicle_id = $request->vehicle_id;
        $vehicle_status_code = $request->status_code;
        $query = AssessmentAccidentVehicle::find($vehicle_id);
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
    
    public function updateDamageEstimatePrice(Request $request){
        $assessment_accident_id = session()->get('accident_current_detail_id');
        $accidentVehicle = AssessmentAccidentVehicle::where('assessment_accident_id', $assessment_accident_id);
        $accidentVehicle->update([
            'estimate_price' => preg_replace('/,/', '', $request->estimate_price)
        ]);
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function hasAssessmentVehicleStatus($code){
        $data = AssessmentVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    private function hasAccidentPercentage($code){
        $data = AssessmentAccidentPercentage::where('code', $code)->first();
        return $data->id;
    }

    public function assessmentStatus($code)
    {
        $status = AssessmentApplicationStatus::where('code',$code)->first();
        return $status->id;
    }
}
