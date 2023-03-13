<?php

namespace App\HTTP\Controllers\Maintenance\NonJKR;

use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetPublic;
use App\Models\Maintenance\MaintenanceDocument;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\Maintenance\MaintenanceType;
use App\Models\Maintenance\MappStatus;
use App\Models\RefCategory;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MaintenanceNonJKRDAO extends Controller
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


    public function mount(Request $request){

        if($request->id > 0){
                $this->id = $request->id;
            }
        $id = $this->id;
        $this->loadDetail($id);
        $this->maintenance_type_list = MaintenanceType::all();
        $this->states = RefState::all();
        $this->categoryList = RefCategory::all();
        $this->brands = Brand::all();
        $this->ref_worksops = RefWorkshop::all();

        session()->put('session_vehicle_id', $id);
        Log::info("ID --> ". $id);
    }

    private function convertDateToSQLDate($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function convertTimeToSQLTime($dateVal, $format){
        return Carbon::createFromFormat('h:i A', $dateVal)->format($format);
    }

    public function saveVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reg_no' => 'required',
            'state_id'  => 'required',
            'alamat1' => 'required',
            'poskod' => 'required',
            'bandar' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'sub_category_type_id' => 'required',
            'engine_no' => 'required',
            'chasis_no' => 'required',
            'brand' => 'required',
            'model' => 'required',
        ],[
            'reg_no.required' => 'Sila Masukkan No Pendaftaran Kenderaan',
            'state_id.required' => 'Sila Pilih Negeri',
            'alamat1.required' => 'Sila Isi Maklumat Alamat Anda',
            'poskod.required' => 'Sila Isi Poskod',
            'bandar.required' => 'Sila Isi Maklumat Bandar',
            'category_id.required' => 'Sila Pilih Kategori',
            'sub_category_id.required' => 'Sila Pilih Sub Kategori',
            'sub_category_type_id.required' => 'Sila Pilih Jenis',
            'engine_no.required' => 'Sila Masukkan Maklumat Engine',
            'chasis_no.required' => 'Sila Masukkan Maklumat Chasis',
            'pembuat.required' => 'Sila Pilih Pembuat',
            'model.required' => 'Sila Pilih Model',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dataFleet = [
            'user_id' => auth()->user()->id,
            'state_id' => $request->state_id ? $request->state_id : null,
            'created_by' => auth()->user()->id,
            'no_pendaftaran' => $request->reg_no,
            'category_id' => $request->category_id ? $request->category_id : null,
            'sub_category_id' => $request->sub_category_id ? $request->sub_category_id : null,
            'sub_category_type_id' => $request->sub_category_type_id ? $request->sub_category_type_id : null,
            'brand_id' => $request->brand ? $request->brand : null,
            'model_id' => $request->model ? $request->model : null,
            'no_chasis' => $request->chasis_no ? $request->chasis_no : null,
            'no_engine' => $request->engine_no ? $request->engine_no : null,
            'vapp_status_id' => 7,
            'vehicle_status_id' => 4,
        ];

        $dataMaintenance = [
            'state_id' => $request->state_id ? $request->state_id : null,
            'address1' => $request->alamat1 ? $request->alamat1 : null,
            'address2' => $request->alamat2 ? $request->alamat2 : null,
            'postcode' => $request->poskod ? $request->poskod : null,
            'city' => $request->bandar ? $request->bandar : null,
            'team_id' => 1,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'maintenance_type_id' => 0,
            'mapp_status_id' => $this->MaintenanceAppStatus('01'),
        ];

        $vehicle = FleetPublic::where('no_pendaftaran', $request->reg_no)->first();

        if(empty($vehicle) || $vehicle == null){
            $vehicle = FleetPublic::create($dataFleet);
            Log::info("data->vehicle: ".$vehicle);

            $dataMaintenance['vehicle_id'] = $vehicle->id;

            $id = session()->get('session_vehicle_id');

            $maintenance = MaintenanceJob::find($id);
            if($maintenance){
                $maintenance->update($dataMaintenance);
            }
            else{
                $maintenance = MaintenanceJob::create($dataMaintenance);

            }
        }
        else{
            $id = session()->get('session_vehicle_id');
            $maintenance = MaintenanceJob::find($id);
            if($maintenance){
                $maintenance->update($dataMaintenance);
                $fleet = FleetPublic::find($maintenance->vehicle_id);
                if($fleet){
                    $fleet->update($dataFleet);
                }
                else{
                    $fleet = FleetPublic::create($dataFleet);
                }
            }else{
                $maintenance = MaintenanceJob::create($dataMaintenance);
                $fleet = FleetPublic::find($maintenance->vehicle_id);
                if($fleet){
                    $fleet->update($dataFleet);
                }
                else{
                    $fleet = FleetPublic::create($dataFleet);
                }

                $this->is_display = 1;
            }
        }

        session()->put('session_vehicle_id', $maintenance->id);

        return [
            'url' => route('maintenance.job.nonjkr.register', ['id' => $maintenance->id])
        ];

    }

    public function saveInfo(Request $request)
    {
        $id = session()->get('session_vehicle_id');

        $validator = Validator::make($request->all(), [
            'maintenance_type_list_selected' => 'required',
            'appointment_dt1' => 'required',
            'name' => 'required',
            'no_ic' => 'required',
            'no_phone' => 'required',
            'email' => 'required',
            'workshop_id' => 'required',
        ],[
            'maintenance_type_list_selected.required' => 'Sila Pilih Jenis Penyelenggaraan',
            'appointment_dt1.required' => 'Sila Pilih Tarikh',
            'name.required' => 'Sila Masukkan Nama',
            'no_ic.required' => 'Sila Masukkan No.Kad Pengenalan',
            'no_phone.required' => 'Sila Masukkan No. Telefon',
            'email.required' => 'Sila Masukkan Email',
            'workshop_id.required' => 'Sila Pilih Bengkel',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dataMaintenance = [
            'maintenance_type_id' => $request->maintenance_type_list_selected,
            'appointment_dt1' => $request->appointment_dt1 ? $this->convertDateToSQLDate($request->appointment_dt1, 'Y-m-d') : null,
            'appointment_dt2' => $request->appointment_dt2 ? $this->convertDateToSQLDate($request->appointment_dt2, 'Y-m-d') : null,
            'appointment_dt3' => $request->appointment_dt3 ? $this->convertDateToSQLDate($request->appointment_dt3, 'Y-m-d') : null,
            'person_name' => $request->name ? $request->name : null,
            'person_ic_no' => $request->no_ic ? $request->no_ic : null,
            'person_phone_no' => $request->no_phone ? $request->no_phone : null,
            'person_email' => $request->email ? $request->email : null,
            'workshop_id' => $request->workshop_id ? $request->workshop_id : null,
        ];

        $maintenance = MaintenanceJob::find($id);

        if($maintenance){

            if($request->quotation_doc == null){
                $maintenance->update($dataMaintenance);
            }
            else{
                if($maintenance->liability_authorised_letter_doc_id == null){

                    $file = $request->quotation_doc;
                    $docFormat = $file->getClientOriginalExtension();
                    $fileName = Str::random(9).'.'.$docFormat;
                    $doc_type = 'surat_pelepasan_tanggungan';

                    if($file != null){

                        $path = 'public/dokumen/maintenance/';

                        $file->storeAs($path, $fileName);

                        $dataDOC = [
                            'doc_path' => 'dokumen/maintenance/',
                            'doc_type' => $doc_type,
                            'doc_format' => $docFormat,
                            'doc_name' => $fileName,
                            'created_by' => auth()->user()->id,
                        ];

                        $doc_create =  MaintenanceDocument::create($dataDOC);
                        $dataMaintenance['liability_authorised_letter_doc_id'] = $doc_create->id;

                        $maintenance->update($dataMaintenance);
                    }
                    else{
                        $maintenance->update($dataMaintenance);
                    }
                }
                else{
                    $dataDOC = MaintenanceDocument::find($maintenance->liability_authorised_letter_doc_id);
                    $file = $request->quotation_doc;
                    $doc_type = 'surat_pelepasan_tanggungan';
                    $docFormat = $file->getClientOriginalExtension();
                    $fileName = Str::random(9).'.'.$docFormat;

                    if($file != null){

                        $path = 'public/dokumen/maintenance/';

                        $file->storeAs($path, $fileName);

                        $dataDOC2 = [
                            'doc_path' => 'dokumen/maintenance/',
                            'doc_type' => $doc_type,
                            'doc_format' => $docFormat,
                            'doc_name' => $fileName,
                            'created_by' => auth()->user()->id,
                        ];

                        if($dataDOC){
                            $fullPath = 'app/public/dokumen/maintenance/'.$dataDOC->doc_name;

                            if(file_exists(storage_path($fullPath))){
                                unlink(storage_path($fullPath));
                            }
                            $dataDOC->update($dataDOC2);
                        }
                        else {
                            $success =  MaintenanceDocument::create($dataDOC2);
                        }
                    }
                }
            }

            Log::info($maintenance);
            session()->put('session_vehicle_id', $maintenance->id);
            $this->is_display = 1;
        }
        return [
            'url' => route('maintenance.job.nonjkr.register', ['id' => $maintenance->id])
        ];

    }

    public function submitForAppointmentNonJKR(){
        $this->id = Session()->get('session_vehicle_id');
        $query = MaintenanceJob::find($this->id);
        $res = $query->update([
            'mapp_status_id' => $this->MaintenanceAppStatus('02')
        ]);

        return $res;
    }

    private function MaintenanceAppStatus($code){
        $status = MappStatus::where('code',$code)->first();

        return $status->id;
    }

    public function loadDetail($id){
        $query = MaintenanceJob::find($id);
        // dd($query->hasVehicle()->brand_id);
        $this->detail = $query;
    }

}


?>
