<?php

namespace App\Http\Controllers\Maintenance\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Job\MaintenanceJobDAO;
use App\Mail\module\maintenance\evaluation\SendEmailVExaminationCompletedAppNotifyToApplicant;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\Maintenance\MaintenanceEvaluation;
use App\Models\Maintenance\MaintenanceEvaluationFormCheckDoc;
use App\Models\Maintenance\MaintenanceEvaluationLetter;
use App\Models\Maintenance\MaintenanceEvaluationLetterCheckList;
use App\Models\Maintenance\MaintenanceEvaluationLetterStatus;
use App\Models\Maintenance\MaintenanceEvaluationLetterType;
use App\Models\Maintenance\MaintenanceEvaluationVehicle;
use App\Models\Maintenance\MaintenanceFormCheckLvl1;
use App\Models\Maintenance\MaintenanceFormCheckLvl2;
use App\Models\Maintenance\MaintenanceFormCheckLvl3;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\Maintenance\MaintenanceJobVehicle;
use App\Models\Maintenance\MaintenanceType;
use App\Models\Maintenance\MaintenanceVehicleStatus;
use App\Models\RefCategory;
use App\Models\RefEvent;
use App\Models\User;
use Carbon\Carbon;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use NumberFormatter;
use Intervention\Image\Facades\Image;

class MaintenanceEvaluationVehicleDAO extends Controller
{

    public function list()
    {
        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $query = MaintenanceEvaluationVehicle::where('maintenance_evaluation_id', $maintenance_evaluation_id);

        if(auth()->user()->isForemenMaintenance()){
            $query->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');
        }

        return $query->latest()->paginate(5);
    }

    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_no' => 'required',
            'engine_no' => 'required',
            'chasis_no' => 'required',
            'vehicle_brand_id' => 'required',
            'model_name' => 'required',
            'current_loc' => 'required',
            'fuel_type_id' => 'required',
        ],
        [
            'plate_no.required' => 'Sila masukkan no pendaftaran',
            'engine_no.required' => 'Sila masukkan no engine',
            'chasis_no.required' => 'Sila masukkan no chasis',
            'vehicle_brand_id.required' => 'Sila pilih buatan',
            'model_name.required' => 'Sila masukkan nama model',
            'current_loc.required' => 'Sila isi maklumat lokasi kenderaan',
            'fuel_type_id.required' => 'Sila pilih jenis bahan bakar',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dataVehicle = [
            'maintenance_evaluation_id' => session()->get('mevaluation_current_detail_id'),
            'plate_no' => $request->plate_no,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'current_loc' => $request->current_loc,
            'fuel_type_id' => $request->fuel_type_id,
        ];

        $this->detail = MaintenanceEvaluationVehicle::find($request->maintenance_vehicle_id);

        if($this->detail){
            // $dataVehicle['purchase_dt'] = $this->convertDateToSQLDateTime($request->purchase_dt, 'Y-m-d');
            // $dataVehicle['registration_vehicle_dt'] = $this->convertDateToSQLDateTime($request->registration_vehicle_dt, 'Y-m-d');
            $dataVehicle['updated_by'] =  Auth::user()->id;
            $query = $this->detail->update($dataVehicle);
            $this->message = 'Maklumat Berjaya Dikemaskini';
            $bench = 'update';
        } else {

            $dataVehicle['maintenance_vehicle_status_id'] = $this->hasMaintenanceVehicleStatus("01");

            $MaintenanceEvaluationVehicleId = session()->get('maintenance_evaluation_vehicle_id');
            $checkIsExisted = FleetDepartment::find($MaintenanceEvaluationVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $MaintenanceEvaluationVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
                $checkIsExisted->update([
                    'is_evaluation' => true
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;
            $query = MaintenanceEvaluationVehicle::create($dataVehicle);
            $this->message = 'Maklumat Berjaya Ditambah';
            $bench = 'create';
        }

        $MaintenanceEvaluation = MaintenanceEvaluation::find(session()->get('mevaluation_current_detail_id'));

        $response = [
            'query' => $query,
            'code' => 200,
            'total_vehicle' => $MaintenanceEvaluation->hasVehicle->count(),
            'message' =>  $this->message,
            'bench' => $bench,
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function getVehicleForm(Request $request)
    {

        $vehicleId = $request->vehicleId;
        $data = MaintenanceEvaluationVehicle::find($vehicleId);
        $array = [
            'id' => $data->id,
            'maintenance_evaluation_id' => $data->maintenance_evaluation_id,
            'category_id' => $data->category_id,
            'sub_category_id' => $data->sub_category_id,
            'sub_category_type_id' => $data->sub_category_type_id,
            'vehicle_brand_id' => $data->vehicle_brand_id,
            'purchase_dt' => $data->purchase_dt,
            'company_name' => $data->company_name,
            'lo_no' => $data->lo_no,
            'is_gover' => $data->is_gover,
            'plate_no' => $data->plate_no,
            'engine_no' => $data->engine_no,
            'chasis_no' => $data->chasis_no,
            'brand_id' => $data->vehicle_brand_id,
            'model_name' => $data->model_name,
            'manufacture_year' => $data->manufacture_year,
            'registration_vehicle_dt' => $data->registration_vehicle_dt,
            'fuel_type_id' => $data->fuel_type_id,
            'current_loc' => $data->current_loc,
        ];
        return json_encode($array);
    }

    public function foremenList(){
        $query = User::whereHas('roles', function($q){
            $q->where('name', '08');
        })->whereHas('detail', function($q){
            $queryMaintenanceEvaluationDetail = MaintenanceEvaluation::find(session()->get('mevaluation_current_detail_id'));
            $q->where('workshop_id', $queryMaintenanceEvaluationDetail->hasWorkShop->id)
            ->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        });
        return $query->get();
    }

    public function assignToFormen(Request $request){
        $query = MaintenanceEvaluationVehicle::find($request->vehicle_id);
        $query->update([
            'foremen_by' => $request->user_id
        ]);
    }

    public function getLetter(Request $request){
        Log::info('$request->vehicle_id' .$request->vehicle_id);
        
        $detail = MaintenanceEvaluationLetter::where([
            // 'evaluation_letter_type_id' => $request->template_type_id,
            'vehicle_id' => $request->vehicle_id
        ])->first();
                
        $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);

        if($detail){
            Log::info("sini");
            session()->put('session_letter_id', $detail->id);

            $detail['total_budget_with_format'] = number_format($detail->total_budget,2);
            $detail['total_budget_with_word'] = ucwords($f->format($detail->total_budget));
        }
        return [
            'detail' => $detail,
            // 'letter_type_list' => MaintenanceEvaluationLetterType::all()
        ];
    }

    public function saveLetterField(Request $request){
        $query = MaintenanceEvaluationLetter::find(session()->get('session_letter_id'));
        $data = [$request->field => $request->value];
        if($query){
            $query->update($data);
        }
    }

    public function saveLetter(Request $request){
        $query = MaintenanceEvaluationLetter::find(session()->get('session_letter_id'));
        $data = [
            'ref_number' => $request->ref_number ? $request->ref_number : $query->ref_number,
            'date' => $request->date ? $request->date : $query->date,
            'address_to' => $request->address_to ? $request->address_to : $query->address_to,
            'vip_address' => $request->vip_address ? $request->vip_address : $query->vip_address,
            'officer_designation' => $request->officer_designation ? $request->officer_designation : $query->officer_designation,
            'placement_name' => $request->placement_name ? $request->placement_name : $query->placement_name,
            'body_detail' => $request->body_detail ? $request->body_detail : $query->body_detail,
            'job_detail' => $request->job_detail ? $request->job_detail : $query->job_detail,
            'syntom' => $request->syntom ? $request->syntom : $query->syntom,
            'accessories' => $request->accessories ? $request->accessories : $query->accessories,
            'budget' => $request->budget ? $request->budget : $query->budget,
            'appointment_dt' => $request->appointment_dt ? $request->appointment_dt : $query->appointment_dt,
            'officer_name' => $request->officer_name ? $request->officer_name : $query->officer_name,
            'officer_phone' => $request->officer_phone ? $request->officer_phone : $query->officer_phone,
            'signature_quote' => $request->signature_quote ? $request->signature_quote : $query->signature_quote
        ];
        if($query){
            $query->update($data);
            $query->hasVehicle->update([
                'evaluation_letter_id' => $query->id
            ]);
        }
    }

    public function saveExamLetter(Request $request){
        $query = MaintenanceEvaluationLetter::find(session()->get('session_letter_id'));
        $data = [
            'ref_number' => $request->ref_number ? $request->ref_number : $query->ref_number,
            'date' => $request->date ? $request->date : $query->date,
        ];
        if($request->exam_letter){
            $data['exam_letter'] = $this->createExamDoc($request->exam_letter, 'exam_letter')->doc_name;
            $data['exam_letter_path'] = 'public/dokumen/maintenance/evaluation/exam_letter';
        }

        if($query){
            $query->update($data);
            $query->hasVehicle->update([
                'evaluation_letter_id' => $query->id
            ]);
        }  
    }

    public function createExamDoc($file, $path){

        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        switch ($path){
            case ($path == 'exam_letter'):
                $path = 'public/dokumen/maintenance/evaluation/exam_letter/';
                break;

            default:
                $path = 'public/dokumen/maintenance/evaluation/';
                break;
        }

        if($file != null){

            Log::info($file);
            Log::info($docFormat);
            Log::info('public/'.$path.$fileName);

            $file->storeAs('public/'.$path, $fileName);

            Log::info($file);

            $data = [
                'doc_path' => $path,
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
            ];

            Log::info($data);

            $inserted = MaintenanceEvaluationFormCheckDoc::create($data);

            return $inserted;
        }
    }

    public function verificationLetter(Request $request){
        Log::info('verificationLetter :: => masuk sini ?');
        Log::info('session ada x ? '.session()->get('session_letter_id'));
        Log::info($request);
        $query = MaintenanceEvaluationLetter::find(session()->get('session_letter_id'));
        if($query){
            Log::info($query);
            $data = [
                'letter_status_id' => $this->letterStatus('02')
            ];
            $query->update($data);
        }

        return [
            'url' => route('maintenance.evaluation.register', [
                'id' => $query->hasVehicle->hasMaintenanceDetail->id,
                'tab' => 6 ])
        ];
    }

    public function approvalLetter(Request $request){
        Log::info('approvalLetter :: => masuk sini ?');
        Log::info('session ada x ? '.session()->get('session_letter_id'));
        Log::info($request);
        $query = MaintenanceEvaluationLetter::find(session()->get('session_letter_id'));
        if($query){
            Log::info($query);
            $data = [
                'letter_status_id' => $this->letterStatus('03')
            ];
            $query->update($data);
        }

        return [
            'url' => route('maintenance.evaluation.register', [
                'id' => $query->hasVehicle->hasMaintenanceDetail->id,
                'tab' => 6 ])
        ];
    }

    public function approveLetter(Request $request){
        $query = MaintenanceEvaluationLetter::find(session()->get('session_letter_id'));
        if($query){
            $data = [
                'letter_status_id' => $this->letterStatus('04')
            ];
            Log::info($query);
            $query->update($data);

            $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();

            if($query->hasVehicle->hasMaintenanceDetail->hasUnVerifyVehicle->count() == 0 &&
            $query->hasVehicle->hasMaintenanceDetail->hasActiveVerifyVehicle->count() == 0 &&
            $query->hasVehicle->hasMaintenanceDetail->hasActiveVehicleLetter->count() == 0)
            {

                $query->hasVehicle->hasMaintenanceDetail->update([
                    'app_status_id' => $MaintenanceEvaluationDAO->maintenanceStatus('08')
                ]);

                $checkExistVehicle = FleetDepartment::where('no_pendaftaran', $query->hasVehicle->plate_no)->first();

                if($checkExistVehicle){
                    $checkExistVehicle->update(
                        [
                            'is_evaluation' => false
                        ]
                    );
                }
            }
        }

        return [
            'url' => route('maintenance.evaluation.register', [
                'id' => $query->hasVehicle->hasMaintenanceDetail->id,
                'tab' => 6 ])
        ];
    }

    private function letterStatus($code){
        $data = MaintenanceEvaluationLetterStatus::where('code', $code)->first();
        return $data->id;
    }

    public function saveLetterCheckList(Request $request){

        $query = MaintenanceEvaluationLetterCheckList::find($request->vehicle_id);
        $query2 = MaintenanceEvaluationLetterCheckList::find($request->id);
        Log::info('MaintenanceEvaluationVehicleDAO :: saveLetterCheckList -> '.$request->vehicle_id);
        Log::info($query);

        $data = [
            'template_letter_type_id' => $request->template_letter_type_id,
            'evaluation_template_letter_id' => $request->evaluation_template_letter_id,
            'job_detail' => $request->job_detail,
            'syntom' => $request->syntom,
            'accessories' => $request->accessories,
            'budget' => $request->budget,
        ];

        
        if($query2){
            $query2->update($data);
            Log::info("query2 -> " .$query2);
        }
        else{
            if($query){
                $data['updated_by'] = Auth::user()->id;
                $query->update($data);
            } else {
                $data['created_by'] = Auth::user()->id;
                MaintenanceEvaluationLetterCheckList::create($data);
                $vDetail = MaintenanceEvaluationVehicle::find($request->vehicle_id);
                $vDetail->update([
                    'evaluation_letter_id' => $request->evaluation_template_letter_id
                ]);
            }
        }

        $this->updateTotalBudget($request->evaluation_template_letter_id);
    }

    public function deleteLetterCheckList(Request $request){

        $query = MaintenanceEvaluationLetterCheckList::find($request->id);
        $evaluation_template_letter_id = $query->hasTemplateLetterDetail->id;
        $query->delete();

        $this->updateTotalBudget($evaluation_template_letter_id);

    }

    private function updateTotalBudget($letter_id){
        $query = MaintenanceEvaluationLetter::find($letter_id);
        $totalBudget = 0;
        foreach ($query->hasCheckList as $key) {
            $totalBudget += $key->budget;
        }
        $data = [
            'total_budget' => $totalBudget
        ];
        $query->update($data);
    }

    public function getLetterCheckList(Request $request){
        $query = MaintenanceEvaluationLetterCheckList::where('evaluation_template_letter_id', $request->evaluation_template_letter_id);
        $query->orderBy('updated_at','desc');
        return $query->get();
    }

    public function getForm(Request $request){
        // dd($request->all());
        $MaintenanceFormCheckLvl1List = MaintenanceFormCheckLvl1::where([
            'maintenance_type_id' => $request->maintenance_type_id,
            'vehicle_id' => $request->vehicle_id
        ])->orderBy('checklistlvl1_id');


        return [
            'CheckLvl1List' => $MaintenanceFormCheckLvl1List->get(),
            'VehicleDetail' => $MaintenanceFormCheckLvl1List->exists() ? $MaintenanceFormCheckLvl1List->first()->hasVehicleDetail : null,
            'category_list' => RefCategory::all(),
        ];
    }

    public function saveForm(Request $request)
    {
        Log::info($request);
        $checkExistFormLvl1 = MaintenanceFormCheckLvl1::where([
            'maintenance_type_id' => $request->maintenance_type_id,
            'vehicle_id' => $request->vehicle_id
        ]);

        $dataVehicle = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_type_id' => $request->sub_category_type_id,
            'department_name' => $request->department_name,
            'odometer' => $request->odometer,
            'date_entry' => $request->date_entry,
        ];

        $queryVehicleDetail = MaintenanceEvaluationVehicle::find($request->vehicle_id);
        if($queryVehicleDetail){
           $queryVehicleDetail->update($dataVehicle);
        }

        //Log::info($request);
        Log::info(' count me -> '.$checkExistFormLvl1->count());

        if($checkExistFormLvl1->count()>0){

            foreach ($checkExistFormLvl1->get() as $CheckList){

                Log::info('masuk sini x ? => '.$CheckList);

                foreach ($CheckList->hasManySelection as $CheckList){
                    Log::info($request['form_selection_id_'.$CheckList->id]);
                    $CheckList->update([
                        'selected_id' => $request['form_selection_id_'.$CheckList->id] ? $request['form_selection_id_'.$CheckList->id] : null
                    ]);
                }

                Log::info($request['form_check_lvl1_component_id_'.$CheckList->id]);
                Log::info($request['form_note_lvl1_component_id_'.$CheckList->id]);
                Log::info($request['form_file_lvl1_component_id_'.$CheckList->id]);

                $data = [
                    'is_pass' => $request['form_check_lvl1_component_id_'.$CheckList->id] ? true: false,
                    'note' => $request['form_note_lvl1_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id
                ];

                $CheckList->update($data);
            }
        }

        $checkExistFormLvl2 = MaintenanceFormCheckLvl2::where('vehicle_id', $request->vehicle_id)->get();
        // Log::info($checkExistFormLvl2);
        if(count($checkExistFormLvl2)>0){

            foreach ($checkExistFormLvl2 as $CheckList){
                Log::info($request['form_check_lvl2_component_id_'.$CheckList->id]);
                Log::info($request['form_note_lvl2_component_id_'.$CheckList->id]);
                Log::info($request['form_file_lvl2_component_id_'.$CheckList->id]);

                $data = [
                    'is_pass' => $request['form_check_lvl2_component_id_'.$CheckList->id] ? true: false,
                    'note' => $request['form_note_lvl2_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id
                ];

                $CheckList->update($data);
            }
        }

        $checkExistFormLvl3 = MaintenanceFormCheckLvl3::where('vehicle_id', $request->vehicle_id)->get();
        // Log::info($checkExistFormLvl3);
        if(count($checkExistFormLvl3)>0){

            foreach ($checkExistFormLvl3 as $CheckList){
                Log::info($request['form_check_lvl3_component_id_'.$CheckList->id]);
                Log::info($request['form_note_lvl3_component_id_'.$CheckList->id]);
                Log::info($request['form_file_lvl3_component_id_'.$CheckList->id]);

                $data = [
                    'is_pass' => $request['form_check_lvl3_component_id_'.$CheckList->id] ? true: false,
                    'note' => $request['form_note_lvl3_component_id_'.$CheckList->id],
                    'noted_by' => Auth::user()->id
                ];

                $CheckList->update($data);
            }
        }

        $data = [
            'foremen_by' => Auth::user()->isForemenMaintenance() ? Auth::user()->id : $queryVehicleDetail->foremen_by,
            'verify_by' => Auth::user()->id
        ];

        $MaintenanceEvaluationVehicle = MaintenanceEvaluationVehicle::find($request->vehicle_id);

        $url = null;
        if($request->save_as != 'draf'){
            $url = route('maintenance.evaluation.register', ["id"=> Request("maintenance_id"), "tab" => 4]);
            if(Auth::user()->isForemenMaintenance()){
                $url = route('access.operation.dashboard');
            }
            if($request->save_as == 'approval'){
                $data['assessment_by'] = Auth::user()->id;
                $data['verify_dt'] = Carbon::now();
                $data['maintenance_vehicle_status_id'] = $this->vehicleStatus('07');
            } else if($request->save_as == 'approve'){
                $data['verify_by'] = Auth::user()->id;
                $data['verify_dt'] = Carbon::now();
                $data['maintenance_vehicle_status_id'] = $this->vehicleStatus('08');
                $this->sendEmailVExaminationCompletedNotificationToApplicant($queryVehicleDetail);
            }
        }

        $MaintenanceEvaluationVehicle->update($data);

        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        $hasUnVerifyVehicle = $MaintenanceEvaluationVehicle->hasMaintenanceDetail->hasUnVerifyVehicle->count();
        $hasActiveVerifyVehicle = $MaintenanceEvaluationVehicle->hasMaintenanceDetail->hasActiveVerifyVehicle->count();
        Log::info('total hasActiveVerifyVehicle '.$hasActiveVerifyVehicle);

        if($hasActiveVerifyVehicle == 0 && $hasUnVerifyVehicle == 0){

            $MaintenanceEvaluationVehicle->hasMaintenanceDetail->update([
                'app_status_id' => $MaintenanceEvaluationDAO->maintenanceStatus('11')
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

        Log::info('masuk /saveFormFile');
        Log::info($request);
        $imgUrl = null;

        switch ($request->lvl) {
            case 2:
                $query = MaintenanceFormCheckLvl2::find($request->id);
                $prevFile = MaintenanceEvaluationFormCheckDoc::find($query->doc_id);
                $inserted = $this->createDoc($request->file, $prevFile ? $prevFile->doc_name : null, $request->vehicle_id);
                $query->update([
                    'doc_id' => $inserted->id
                ]);
                $imgUrl = '/dokumen/maintenance/evaluation/'.$inserted->doc_name;
                break;
            case 3:
                $query = MaintenanceFormCheckLvl3::find($request->id);
                $prevFile = MaintenanceEvaluationFormCheckDoc::find($query->doc_id);
                $inserted = $this->createDoc($request->file, $prevFile ? $prevFile->doc_name : null, $request->vehicle_id);
                $query->update([
                    'doc_id' => $inserted->id
                ]);
                $imgUrl = '/dokumen/maintenance/evaluation/'.$inserted->doc_name;
                break;
        }

        $response = [
            'code' => 200,
            'imgUrl' => $imgUrl,
            'message' => 'Gambar berjaya dimuatnaik'
        ];
        return $response;
    }

    private function createDoc($file, $prevFilename, $ref_id){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $mjobvMonitorThumbnailPath = public_path('/thumbnails/maintenance/evaluation/');

            if(!is_dir($mjobvMonitorThumbnailPath)) {

                mkdir($mjobvMonitorThumbnailPath, 0755, true);
            }

            if($docFormat == '.jpeg' || $docFormat == '.png' || $docFormat == '.jpg' || $docFormat == '.gif'){
                $img = Image::make($file->path());
                $img->resize(250, 150, function ($const) {
                    $const->aspectRatio();
                })->save($mjobvMonitorThumbnailPath.'/'.$fileName);
            }
            else{
               
                $img = Image::make($file->path());
                $img->save($mjobvMonitorThumbnailPath.'/'.$fileName);
            }

            $path = 'public/dokumen/maintenance/evaluation/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path_thumbnail' => 'thumbnails/maintenance/evaluation/',
                'doc_path' => 'dokumen/maintenance/evaluation/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id
            ];

            $prevPath = $mjobvMonitorThumbnailPath.'/'.$prevFilename;
            if($prevFilename && file_exists($prevPath)){
                Log::info('unlink small size '.$prevPath);
                unlink($prevPath);
            }

            $prevStoragePath = public_path().'/storage/dokumen/maintenance/evaluation/'.$prevFilename;
            if($prevFilename && file_exists($prevStoragePath)){
                Log::info('unlink big size '.$prevStoragePath);
                unlink($prevStoragePath);
            }
            flush();

            Log::info($data);
            $inserted = MaintenanceEvaluationFormCheckDoc::create($data);
            Log::info($inserted->id);
            return $inserted;
        }
    }

    public function deleteDocFile(Request $request){
        $comp_lvl = $request->comp_lvl;
        $comp_id = $request->comp_id;
        $query = null;

        switch ($comp_lvl) {
            case 1:
                $query = MaintenanceFormCheckLvl1::find($comp_id);
                break;
            case 2:
                $query = MaintenanceFormCheckLvl2::find($comp_id);
                break;
            case 3:
                $query = MaintenanceFormCheckLvl3::find($comp_id);
                break;
        }

        if($query){
            $query->update([
                'doc_id' => null
            ]);

            $id = $request->id;
            $this->deletePrevDoc($id);
        }
    }

    private function deletePrevDoc($id){
        Log::info('file_id => '.$id);
        $query = MaintenanceEvaluationFormCheckDoc::find($id);
        if($query){
            $query->delete();
            $path = public_path().'/storage/'.$query->doc_path.$query->doc_name;
            unlink($path);
            flush();
        }
    }

    public function proceedToMJob(Request $request){

        $inserted = null;
        Log::info(' masuk /proceedToMJob ');
        Log::info($request->ids);
        $vList = MaintenanceEvaluationVehicle::whereIn('id', $request->ids);
        //TODO
        $vList->where('is_carry_over_maintenance', false);
        $MaintenanceJobDAO = new MaintenanceJobDAO();

        $index = 0;

        foreach ($vList->get() as $v) {
            $index++;
            $query = MaintenanceEvaluationVehicle::find($v->id);
            if($index == 1) {
                $data = [
                    'applicant_name' => $query->hasMaintenanceDetail->applicant_name,
                    'phone_no' => $query->hasMaintenanceDetail->phone_no,
                    'email' => $query->hasMaintenanceDetail->email,
                    'address' => $query->hasMaintenanceDetail->address,
                    'postcode' => $query->hasMaintenanceDetail->postcode,
                    'state_id' => $query->hasMaintenanceDetail->state_id,
                    'department_name' => $query->hasMaintenanceDetail->department_name,
                    'hod_name' => $query->hasMaintenanceDetail->hod_name,
                    'appointment_dt1' => $query->hasMaintenanceDetail->date_1,
                    'appointment_dt2' => $query->hasMaintenanceDetail->date_2,
                    'appointment_dt3' => $query->hasMaintenanceDetail->date_3,
                    'agency_id' => $query->hasMaintenanceDetail->agency_id,
                    'applicant_workshop_id' => $query->hasMaintenanceDetail->applicant_workshop_id,
                    'workshop_id' => $query->hasMaintenanceDetail->applicant_workshop_id,
                    'created_by' => auth()->user()->id,
                ];

                $data['ref_number'] = $MaintenanceJobDAO->generateRefNumber($data, $query->hasMaintenanceDetail->hasWorkShop->id);
                $data['app_status_id'] = $MaintenanceJobDAO->maintenanceStatus("01");
                $inserted = MaintenanceJob::create($data);
            }

            $dataVehicle = [
                'maintenance_job_id' => $inserted->id,
                'maintenance_job_purpose_type' => $query->maintenance_job_purpose_type,
                'last_service_dt' => $query->last_service_dt ? $this->convertDateToSQLDateTime($query->last_service_dt, 'Y-m-d') : null,
                'complaint_damage' => $query->complaint_damage,
                'plate_no' => $query->plate_no,
                'engine_no' => $query->engine_no,
                'chasis_no' => $query->chasis_no,
                'vehicle_brand_id' => $query->vehicle_brand_id,
                'model_name' => $query->model_name,
                'current_loc' => $query->current_loc,
                'fuel_type_id' => $query->fuel_type_id
            ];

            $dataVehicle['maintenance_vehicle_status_id'] = $this->hasMaintenanceVehicleStatus("01");

            $MaintenanceJobVehicleId = session()->get('maintenance_job_vehicle_id');
            $checkIsExisted = FleetDepartment::find($MaintenanceJobVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $MaintenanceJobVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;

            MaintenanceJobVehicle::create($dataVehicle);

            $v->update([
                'is_carry_over_maintenance' => true
            ]);

        }

        return [
            'url' => route('maintenance.job.register', [
                'id' => $inserted->id,
                'tab' => 2
            ])
        ];
    }

    public function updateStatus(Request $request){
        Log::info($request);
        $vehicle_id = $request->vehicle_id;
        $vehicle_status_code = $request->status_code;
        $query = MaintenanceEvaluationVehicle::find($vehicle_id);
        $query->update([
            'maintenance_vehicle_status_id' => $this->vehicleStatus($vehicle_status_code)
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

    public function searchByPlateNo(Request $request)
    {

        $detail = null;
        if($request->search){
            $detail = MaintenanceEvaluationVehicle::whereRaw("upper(plate_no) = '".strtoupper($request->search)."'")->get();
        }

        return $detail;
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = MaintenanceEvaluationVehicle::whereIn('id', $ids);

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

    private function createExamFile($file, $path){

        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;
        Log::info("filename => ".$fileName);

        $path = 'public/dokumen/maintenance/evaluation/';
        Log::info("path => ".$path);

        if($file != null){

            Log::info($file);
            Log::info($docFormat);
            Log::info('public/'.$path.$fileName);

            $file->storeAs('public/'.$path, $fileName);

            Log::info("file -> " .$file);

            $data = [
                'exam_letter_path' => $path,
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
            ];

            $inserted = MaintenanceEvaluationLetter::create($data);

            return $inserted;
        }
    }


    
    private function vehicleStatus($code){
        Log::info($code);
        $query = MaintenanceVehicleStatus::where('code', $code)->first()->id;
        Log::info('MaintenanceVehicleStatusDAO :: vehicleStatus');
        Log::info($query);
        return $query;
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function hasMaintenanceVehicleStatus($code){
        $data = MaintenanceVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    private function hasMaintenanceType($code){
        $data = MaintenanceType::where('code', $code)->first();
        return $data->id;
    }

    private function sendEmailVExaminationCompletedNotificationToApplicant($detail){
        $emailBody = [
            'title' => 'Maklumat Kenderaan Telah Selesai',
            'subject' => 'Maklumat Kenderaan '.Carbon::now()->format('d/m/Y'),
            'detail' => $detail,
        ];

        $userEmail = ['farid.developer.1992@gmail.com'];
        array_push($userEmail, $detail->hasMaintenanceDetail->email);

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailVExaminationCompletedAppNotifyToApplicant($emailBody));
    }
}
