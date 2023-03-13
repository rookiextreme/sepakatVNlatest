<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Assessment\Safety\Vehicle\AssessmentSafetyVehicleDAO;
use App\Http\Controllers\Controller;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentAccidentVehicleDamageForm;
use App\Models\Assessment\AssessmentDisposalVehicle;
use App\Models\Assessment\AssessmentFormCheckDoc;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use App\Models\Assessment\AssessmentFormCheckLvl3;
use App\Models\Assessment\AssessmentType;
use App\Models\Assessment\AssessmentNewFormCheckDoc;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentSafetyFormCheckDoc;
use App\Models\Assessment\AssessmentSafetyVehicle;
use App\Models\Assessment\AssessmentVehicleImage;
use App\Models\Maintenance\MaintenanceEvaluationFormCheckDoc;
use App\Models\Maintenance\MaintenanceFormCheckLvl2;
use App\Models\Maintenance\MaintenanceFormCheckLvl3;
use App\Models\Maintenance\MaintenanceJobDoc;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationForm;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormRepair;
use App\Models\Maintenance\MonitoringInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileUploadMobileDAO extends Controller {

    private $objPath;
    public $damage_id = -1;

    public function __construct()
    {
        $this->objPath =  [
            '01' => [
                "p1" => 'public/dokumen/assessment/new/',
                'p2' => 'dokumen/assessment/new/'
            ],
            '02' => [
                "p1" => 'public/dokumen/assessment/safety/',
                'p2' => 'dokumen/assessment/safety/'
            ],
            '03' => [
                "p1" => 'public/dokumen/assessment/accident/',
                'p2' => 'dokumen/assessment/accident/'
            ],
            '04' => [
                "p1" => 'public/dokumen/assessment/currvalue/',
                'p2' => 'dokumen/assessment/currvalue/'
            ],
            '05' => [
                "p1" => 'public/dokumen/assessment/govloan/',
                'p2' => 'dokumen/assessment/govloan/'
            ],
            '06' => [
                "p1" => 'public/dokumen/assessment/disposal/',
                'p2' => 'dokumen/assessment/disposal/'
            ],
        ];
    }

    public function saveFormFile(Request $request){

        try {

            config(['assessment_type_code' => $request->assessment_type_code]);
            $fileType = $request->file_type;
            if($fileType == "vtl" && $fileType != null){

                $file_id = $this->createDoc($request->file, $request->vehicle_id,$request->user_id,$request->assessment_type_code)->id;
                switch ($request->assessment_type_code) {
                    case "06":
                    
                        $query = AssessmentDisposalVehicle::find($request->vehicle_id);
                        $query->update([
                            'vtl_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentDisposalVehicle::where('id', $request->vehicle_id)
                                ->with('hasVtlDoc')
                                ->get(); 

                        break;
                    case "05":
                
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vtl_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentFormCheckLvl1::where('id', $request->id)
                                ->with('hasVtlDoc')
                                ->get();

                        break;
                    case "04":
            
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vtl_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentFormCheckLvl1::where('id', $request->id)
                                ->with('hasVtlDoc')
                                ->get();

                        break;
                    case "02":

                        $query = AssessmentSafetyVehicle::find($request->vehicle_id);
                        $query->update([
                            'vtl_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentSafetyVehicle::where('id', $request->vehicle_id)
                                ->with('hasVtlDoc')
                                ->get();            
                        break;
                    case "01":

                        $query = AssessmentNewVehicle::find($request->vehicle_id);
                        $query->update([
                            'vtl_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentNewVehicle::where('id', $request->vehicle_id)
                                ->with('hasVtlDoc')
                                ->get();            
                        break;
                }

            }else if($fileType == "veh_img" && $fileType != null){

                $file_id = $this->createDoc($request->file, $request->vehicle_id,$request->user_id,$request->assessment_type_code)->id;

                switch ($request->assessment_type_code) {
                    case "05":
                    
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vehicle_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentFormCheckLvl1::where('id', $request->id)
                                ->with('hasVehicleImgDoc')
                                ->get();
                        break;
                    case "04":
        
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vehicle_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentFormCheckLvl1::where('id', $request->id)
                                ->with('hasVehicleImgDoc')
                                ->get();
                        break;                    
                    case "06":

                        $query = AssessmentDisposalVehicle::find($request->vehicle_id);
                        $query->update([
                            'veh_img_doc' => $file_id
                        ]);
        
                        $hasDoc = AssessmentDisposalVehicle::where('id', $request->vehicle_id)
                                ->with('hasVehicleImgDoc')
                                ->get(); 
                        break;   
                    case "01":

                        $query = AssessmentNewVehicle::find($request->vehicle_id);
                        $query->update([
                            'veh_img_doc' => $file_id
                        ]);
        
                        $hasDoc = AssessmentNewVehicle::where('id', $request->vehicle_id)
                                ->with('hasVehicleImgDoc')
                                ->get(); 

                        break;
                }

            }else if($fileType == "receipt" && $fileType != null){

                $file_id = $this->createDoc($request->file, $request->vehicle_id,$request->user_id,$request->assessment_type_code)->id;
                switch ($request->assessment_type_code) {
                    case "01":
                    
                        $query = AssessmentNewVehicle::find($request->vehicle_id);
                        $query->update([
                            'receipt_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentNewVehicle::where('id', $request->vehicle_id)
                                ->with('hasReceiptDoc')
                                ->get();
                        break;        
                    case "05":

                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'receipt_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentFormCheckLvl1::where('id', $request->id)
                                ->with('hasReceiptDoc')
                                ->get();
                        break;
                    case "04":

                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'receipt_doc' => $file_id
                        ]);

                        $hasDoc = AssessmentFormCheckLvl1::where('id', $request->id)
                                ->with('hasReceiptDoc')
                                ->get();
                        break;
                }

            }else if($fileType == "damage_img" && $fileType != null){

                $file_id = $this->createDoc($request->file, $request->vehicle_id,$request->user_id,$request->assessment_type_code)->id;
                $query = AssessmentAccidentVehicleDamageForm::find($request->id);
                $query->update([
                    'doc_id' => $file_id
                ]);

                $hasDoc = AssessmentAccidentVehicleDamageForm::where('id', $request->id)
                        ->with('hasDamageImage')
                        ->get(); 
            }else if($fileType == "all_veh_img" && $fileType != null){

                $this->createVehImgDoc($request->file, $request->vehicle_id,$request->user_id,$request->assessment_type_code);
                $hasDoc = AssessmentVehicleImage::where([
                    'vehicle_id' => $request->vehicle_id,
                    'assessment_type_id' => $this->hasAssessmentType($request->assessment_type_code)
                ])->orderBy('updated_at', 'desc')->get();

            }
            else{
                switch ($request->lvl) {
                    case 2:
                        $file_id = $this->createDoc($request->file, $request->vehicle_id,$request->user_id,$request->assessment_type_code)->id;
                        $query = AssessmentFormCheckLvl2::find($request->id);
                        $query->update([
                            'doc_id' => $file_id
                        ]);
        
                        $hasDoc = AssessmentFormCheckLvl2::where('id', $request->id)
                        ->with('hasDoc')
                        ->get(); 
        
                        break;
                    case 3:
                        $file_id = $this->createDoc($request->file, $request->vehicle_id,$request->user_id,$request->assessment_type_code)->id;
                        $query = AssessmentFormCheckLvl3::find($request->id);
                        //$query = AssessmentFormCheckLvl3::where('id', $request->id)->first();
                        
                        $query->update([
                            'doc_id' => $file_id
                        ]);
        
                        $hasDoc = AssessmentFormCheckLvl3::where('id', $request->id)
                        ->with('hasDoc')
                        ->get(); 
                    
                        break;
                }
            }
            $response = [
                'status' => true,
                'message' => 'Gambar berjaya dimuatnaik',
                'data' => $hasDoc
            ];
    
            return $response;

        } catch (\Throwable $th) {
            
            Log::info("Error :: saveFormFile --> ".$th);
            $response = [
                'status' => false,
                'message' => $th
            ];
            return $response;
        }
    }
    public function deleteFormFile(Request $request){

        try {

            $fileType = $request->file_type;
            if($fileType == "vtl" && $fileType != null){

                switch ($request->assessment_type_code) {
                    case "06":
                    
                        $query = AssessmentDisposalVehicle::find($request->vehicle_id);
                        $query->update([
                            'vtl_doc' => null
                        ]);

                        break;
                    case "05":
                
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vtl_doc' => null
                        ]);

                        break;
                    case "04":
            
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vtl_doc' => null
                        ]);

                        break;
                    case "02":

                        $query = AssessmentSafetyVehicle::find($request->vehicle_id);
                        $query->update([
                            'vtl_doc' => null
                        ]);
           
                        break;
                    case "01":

                        $query = AssessmentNewVehicle::find($request->vehicle_id);
                        $query->update([
                            'vtl_doc' => null
                        ]);

                        break;
                }

            }else if($fileType == "veh_img" && $fileType != null){

                switch ($request->assessment_type_code) {
                    case "05":
                    
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vehicle_doc' => null
                        ]);

                        break;
                    case "04":
        
                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'vehicle_doc' => null
                        ]);

                        break;                    
                    case "06":

                        $query = AssessmentDisposalVehicle::find($request->vehicle_id);
                        $query->update([
                            'veh_img_doc' => null
                        ]);
        
                        break;   
                    case "01":

                        $query = AssessmentNewVehicle::find($request->vehicle_id);
                        $query->update([
                            'veh_img_doc' => null
                        ]);

                        break;
                }

            }else if($fileType == "receipt" && $fileType != null){

                switch ($request->assessment_type_code) {
                    case "01":
                    
                        $query = AssessmentNewVehicle::find($request->vehicle_id);
                        $query->update([
                            'receipt_doc' => null
                        ]);

                        break;        
                    case "05":

                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'receipt_doc' => null
                        ]);

                        break;
                    case "04":

                        $query = AssessmentFormCheckLvl1::find($request->id);
                        $query->update([
                            'receipt_doc' => null
                        ]);

                        break;
                }

            }else if($fileType == "damage_img" && $fileType != null){

                $query = AssessmentAccidentVehicleDamageForm::find($request->id);
                $query->update([
                    'doc_id' => null
                ]);

            }
            else{
                switch ($request->lvl) {
                    case 2:
                      
                        $query = AssessmentFormCheckLvl2::find($request->id);
                        $query->update([
                            'doc_id' => null
                        ]);
        
                        break;
                    case 3:
                       
                        $query = AssessmentFormCheckLvl3::find($request->id);
                        //$query = AssessmentFormCheckLvl3::where('id', $request->id)->first();
                        
                        $query->update([
                            'doc_id' =>null
                        ]);
                    
                        break;
                }
            }
            $response = [
                'status' => true,
                'message' => 'Gambar berjaya dihapus',
            ];
    
            return $response;

        } catch (\Throwable $th) {
            
            Log::info("Error :: saveFormFile --> ".$th);
            $response = [
                'status' => false,
                'message' => $th
            ];
            return $response;
        }
    }
    public function saveMtnFormFile(Request $request){

        try {

            $fileType = $request->file_type;

            switch ($request->lvl) {
                case 2:
                    $query = MaintenanceFormCheckLvl2::find($request->id);
                    $prevFile = MaintenanceEvaluationFormCheckDoc::find($query->doc_id);
                    $file_id = $this->createDocMtn($request->file, $request->vehicle_id,$request->user_id,$prevFile ? $prevFile->doc_name : null)->id;
                    $query->update([
                        'doc_id' => $file_id
                    ]);

                    $hasDoc = MaintenanceFormCheckLvl2::where('id', $request->id)
                    ->with('hasDoc')
                    ->get(); 

                    break;
                case 3:
                    $query = MaintenanceFormCheckLvl3::find($request->id);
                    $prevFile = MaintenanceEvaluationFormCheckDoc::find($query->doc_id);
                    $file_id = $this->createDocMtn($request->file, $request->vehicle_id,$request->user_id,$prevFile ? $prevFile->doc_name : null)->id;
                    $query->update([
                        'doc_id' => $file_id
                    ]);

                    $hasDoc = MaintenanceFormCheckLvl3::where('id', $request->id)
                    ->with('hasDoc')
                    ->get(); 

                    break;
            }

        } catch (\Throwable $th) {
            
            Log::info("Error :: saveMtnFormFile --> ".$th);
            $response = [
                'status' => false,
                'message' => $th,
            ];
            return $response;
        }
        $response = [
            'status' => true,
            'message' => 'Gambar berjaya dimuatnaik',
            'data' => $hasDoc
        ];

        return $response;
    }
    public function saveSignature(Request $request){

        try {

            $query = MaintenanceJobVehicleExaminationForm::find($request->form_id);
                    $prevFile = MaintenanceJobDoc::find($query->company_signature);
                    $file_id = $this->createJobDoc($request->file, $request->vehicle_id,$request->user_id,$prevFile ? $prevFile->doc_name : null)->id;
                    $query->update([
                        'company_signature' => $file_id
                    ]);

                    $hasDoc = MaintenanceJobVehicleExaminationForm::where('id', $request->form_id)
                    ->with('hasSignatureDoc')
                    ->get(); 

        } catch (\Throwable $th) {
            
            Log::info("Error :: saveSignature --> ".$th);
            $response = [
                'status' => false,
                'message' => $th,
            ];
            return $response;
        }
        $response = [
            'status' => true,
            'message' => 'Tandatangan berjaya dimuatnaik',
            'data' => $hasDoc
        ];

        return $response;
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
    public function addVehicleDamage(Request $request){
       Log::info("saveForm request ->");
        try {
            $data = [
                'damage' => $request->damage,
                'damage_note' => $request->damage_note ? $request->damage_note : "",
                'is_repair' => $request->is_repair ? $request->is_repair : false,
                'is_replace' => $request->is_replace ? $request->is_replace : false,
                //'price_list' => $request->price_list ? $request->price_list : null,
            ];
            $damage_id = $request->damage_id ? $request->damage_id : $this->damage_id;
    
            $AssessmentAccidentVehicleDamageForm = AssessmentAccidentVehicleDamageForm::find($damage_id);
            $AssessmentAccidentVehicle = AssessmentAccidentVehicle::where('assessment_accident_id', $request->vehicle_id)->first();
            $data['assessment_accident_vehicle_id'] = $AssessmentAccidentVehicle->id;
    
            if(!$AssessmentAccidentVehicleDamageForm){
                $data['created_by'] = $request->user_id;
                $query = AssessmentAccidentVehicleDamageForm::create($data);
                $this->message = "Maklumat Berjaya Ditambah";
            }else{
                $data['updated_by'] = $request->user_id;
                $query = $AssessmentAccidentVehicleDamageForm->update($data);
                $this->message = "Maklumat Berjaya Dikemaskini";
            }
    
            $response = [
                'status' => true,
                'message' => $this->message,
            ];
    
            Log::info($response);
            return $response;
        } catch (\Throwable $th) {
            Log::info("Error :: damageForm --> ".$th);
            $response = [
                'status' => true,
                'message' => $th,
            ];
        }
        
    }
    public function saveMonitoringInfo(Request $request){

        $query = MonitoringInfo::find($request->id);
        $formRepairId = MaintenanceJobVehicleExaminationFormRepair::where([
            'jve_form_id' => $request->form_id,
            'repair_method_id' => 2
        ])->pluck('id')->first();

        $data = [
            'form_id' => $request->form_id,
            'ref_info_id' => $request->ref_info_id,
            'monitoring_dt' => $request->monitoring_dt,
            'jve_form_repair_id' => $formRepairId,
            'note' => $request->note,
            'created_by' => $request->user_id
        ];
        
        if($query){
            $data['updated_by'] = $request->user_id;
            $query->update($data);
            $message = 'Maklumat berjaya dikemaskini';
        } else {
            $query = MonitoringInfo::create($data);

            $message = 'Maklumat berjaya ditambah';
        }

        if($request->monitoring_file){
            $prevFilename = $query->doc_name;
            $res = $this->createMonitoringFile($request->monitoring_file, $prevFilename);
            $query->update($res);
            
        }

        $data = MonitoringInfo::where([
            'form_id' => $request->form_id
        ])
        ->with('hasRefInfo')
        ->orderBy('updated_at','desc');
       
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $data->get(),
        ];

        return $response;
    }
    public function deleteMonitoringInfo(Request $request){

        $query = MonitoringInfo::where('id',$request->id);
        if($query){
            $query->delete();
        }
        $response = [
            'status' => true,
            'message' => 'Maklumat berjaya dihapus'
        ];
        return $response;
    }
    private function createMonitoringFile($file, $prevFilename){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $mjobvMonitorThumbnailPath = public_path('/thumbnails/maintenance/job/vehicle/');

            if(!is_dir($mjobvMonitorThumbnailPath)) {

                mkdir($mjobvMonitorThumbnailPath, 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(250, 150, function ($const) {
                $const->aspectRatio();
            })->save($mjobvMonitorThumbnailPath.'/'.$fileName);

            $path = 'public/dokumen/maintenance/job/vehicle/monitoring/';

            $file->storeAs($path, $fileName);

            $data = [
                'doc_path_thumbnail' => 'thumbnails/maintenance/job/vehicle/',
                'doc_path' => 'dokumen/maintenance/job/vehicle/monitoring/',
                'doc_type' => 'monitoring_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName
            ];

            $prevPath = $mjobvMonitorThumbnailPath.'/'.$prevFilename;
            if($prevFilename && file_exists($prevPath)){
                Log::info('unlink small size '.$prevPath);
                unlink($prevPath);
            }

            $prevStoragePath = public_path().'/storage/dokumen/maintenance/job/vehicle/monitoring/'.$prevFilename;
            if($prevFilename && file_exists($prevStoragePath)){
                Log::info('unlink big size '.$prevStoragePath);
                unlink($prevStoragePath);
            }
            flush();

            Log::info($data);
            return $data;
        }
    }
    private function createDoc($file, $ref_id, $user_id,$assessment_type_code){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = $this->objPath[$assessment_type_code]['p1'];

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => $this->objPath[$assessment_type_code]['p2'],
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => $user_id,
                'assessment_type_id' => $this->hasAssessmentType($assessment_type_code)
            ];

            Log::info($data);

            return AssessmentFormCheckDoc::create($data);

            // switch ($assessment_type_code) {
            //     case '01':
            //         return AssessmentNewFormCheckDoc::create($data);
            //         break;
            //     case '02':
            //         return AssessmentSafetyFormCheckDoc::create($data);
            //         break;
            //     default:
            //         break;
            // }
        }
    }
    private function createDocMtn($file, $ref_id, $user_id, $prevFilename){

        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $mjobvMonitorThumbnailPath = public_path('/thumbnails/maintenance/evaluation/');

            if(!is_dir($mjobvMonitorThumbnailPath)) {

                mkdir($mjobvMonitorThumbnailPath, 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(250, 150, function ($const) {
                $const->aspectRatio();
            })->save($mjobvMonitorThumbnailPath.'/'.$fileName);

            $path = 'public/dokumen/maintenance/evaluation/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path_thumbnail' => 'thumbnails/maintenance/evaluation/',
                'doc_path' => 'dokumen/maintenance/evaluation/',
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => $user_id
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
    private function createJobDoc($file, $ref_id, $user_id, $prevFilename){

        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $mjobvMonitorThumbnailPath = public_path('/thumbnails/maintenance/job/');

            if(!is_dir($mjobvMonitorThumbnailPath)) {

                mkdir($mjobvMonitorThumbnailPath, 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(250, 150, function ($const) {
                $const->aspectRatio();
            })->save($mjobvMonitorThumbnailPath.'/'.$fileName);

            $path = 'public/dokumen/maintenance/job/';

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path_thumbnail' => 'thumbnails/maintenance/job/',
                'doc_path' => 'dokumen/maintenance/job/',
                'doc_type' => 'signature_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => $user_id
            ];

            $prevPath = $mjobvMonitorThumbnailPath.'/'.$prevFilename;
            if($prevFilename && file_exists($prevPath)){
                Log::info('unlink small size '.$prevPath);
                unlink($prevPath);
            }

            $prevStoragePath = public_path().'/storage/dokumen/maintenance/job/'.$prevFilename;
            if($prevFilename && file_exists($prevStoragePath)){
                Log::info('unlink big size '.$prevStoragePath);
                unlink($prevStoragePath);
            }
            flush();

            Log::info($data);
            $inserted = MaintenanceJobDoc::create($data);
            Log::info($inserted->id);
            return $inserted;
        }
    }
    private function createVehImgDoc($file, $ref_id, $user_id,$assessment_type_code){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = $this->objPath[$assessment_type_code]['p1'];

            $file->storeAs($path, $fileName);

            $data = [
                'ref_id' => $ref_id,
                'doc_path' => $this->objPath[$assessment_type_code]['p2'],
                'doc_type' => 'form_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => $user_id,
                'vehicle_id' => $ref_id,
                'assessment_type_id' => $this->hasAssessmentType($assessment_type_code)
            ];

            Log::info($data);

            return AssessmentVehicleImage::create($data);

        }
    }
    private function hasAssessmentType($code){
        $data = AssessmentType::where('code', $code)->first();
        return $data->id;
    }

}