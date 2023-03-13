<?php

namespace App\Repositories\Summon;

use App\Http\Controllers\Vehicle\Summon\FormMaklumatSaman;
use App\Models\Fleet\FleetEventHistory;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\RefEvent;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\Saman\Status\StatusSaman;
use App\Models\Saman\SummonDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RegisterSummonRepository
{
    public function storeVehicleInformation($data)
    {
        $vehicle = FleetLookupVehicle::find($data['vehicle_id']);
        $maklumatSaman = "";
        if(session()->get('session_summon_id')){
            $maklumatSaman = MaklumatKenderaanSaman::find(session()->get('session_summon_id'));
        }

        $summonStatus = StatusSaman::where('code', '01')->first();
        $summonId = -1;

        Log::info('/storeVehicleInformation');
        Log::info($maklumatSaman);

        if($maklumatSaman){


            if($data['has_summon_notice_doc'] == 1){

                if($data['summon_notice_doc'] != null){
                    $this->updateDoc($maklumatSaman->summon_notice_doc_id, $data['summon_notice_doc'], 'notis_saman');
                }

                $data['summon_notice_doc_id'] = $maklumatSaman->summon_notice_doc_id;
            } else {
                $insertedDoc = $this->createDoc($data['summon_notice_doc'], 'notis_saman');
                $data['summon_notice_doc_id'] = $insertedDoc->id;
            }

            $maklumatSaman->update([
                'user_id' => $data['owner_id'],
                'emel_ketua_jabatan' => $data['head_email'],
                'status_saman_id' => $summonStatus->id,
                'alamat_pejabat_pemilik' => $data['owner_address'],
                'summon_notice_doc_id' => $data['summon_notice_doc_id']
            ]);
            $summonId = session()->get('session_summon_id');
        } else {

            if($data['summon_notice_doc']){
                $insertedDoc = $this->createDoc($data['summon_notice_doc'], 'notis_saman');
                $data['summon_notice_doc_id'] = $insertedDoc->id;
            }

            $summon = MaklumatKenderaanSaman::create(
                [
                    'pendaftaran_id' => $vehicle->id,
                    'user_id' => $data['owner_id'],
                    'emel_ketua_jabatan' => $data['head_email'],
                    'status_saman_id' => $summonStatus->id,
                    'alamat_pejabat_pemilik' => $data['owner_address'],
                    'summon_notice_doc_id' => $data['summon_notice_doc_id']
                ]
            );

            $vehicleEvent = RefEvent::where('code', '06')->first();

            if($summon->id > 0){
                FleetEventHistory::create([
                    'vehicle_id' => $vehicle->id,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
            }

            $summonId = $summon->id;
        }

        $FormMaklumatSaman = new FormMaklumatSaman();
        session()->put('session_summon_id', $summonId);
        Log::info('call FormMaklumatSaman');
        Log::info($data);

        $FormMaklumatSaman->store($data);

        Session::flash('message', 'Berjaya Di Simpan');

        return [
            'id' => $summonId
        ];
    }

    public function storeSummonInformation($data)
    {
        $summon = MaklumatKenderaanSaman::find($data['id']);

        Log::info('masuk sini x ');
        Log::info($data);

        $data = [
            'summon_agency_id' => $data['summon_agency_id'],
            'summon_type_id' => $data['summon_type_id'],
            'state_id' => $data['state_id'],
            'district_id' => $data['district_id'] != -1 ? $data['district_id'] : null,
            'branch_id' => $data['branch_id'],
            'summon_notice_no' => $data['summon_notice_no'],
            'notice_date' => $data['notice_date'],
            'receive_notice_date' => $data['receive_notice_date'],
            'mistake_date' => $data['mistake_date'],
            'mistake_time' => $data['mistake_time'],
            'mistake_location' => $data['mistake_location'],
            'driver_id' => $data['driver_id'],
            'total_compound' => str_replace(',', '', $data['total_compound']),
            'compound_reason' => $data['compound_reason'],
            'pic_name1' => $data['pic_name1'],
            'pic_email1' => $data['pic_email1'],
            'pic_name2' => $data['pic_name2'],
            'pic_email2' => $data['pic_email2']
        ];

        if(empty($summon->maklumatSaman)){
            $data['created_by']  = auth()->user()->id;
            $summon->maklumatSaman()->create($data);
        } else {
            $summon->maklumatSaman->update($data);
        }

        Session::flash('message', 'Berjaya Di Simpan');

        return [
            'status' => 'success'
        ];
    }

    private function createDoc($file, $doc_type){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/summon/';

            $file->storeAs($path, $fileName);

            $data = [
                'doc_path' => 'dokumen/summon/',
                'doc_type' => $doc_type,
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
            ];

            Log::info($data);

            return SummonDocument::create($data);
        }
    }

    private function updateDoc($id, $file, $doc_type){

        $query = SummonDocument::find($id);

        Log::info('func :: updateDoc '.$id);
        Log::info($query);

        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/summon/';

            $file->storeAs($path, $fileName);

            $data = [
                'doc_path' => 'dokumen/summon/',
                'doc_type' => $doc_type,
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
            ];

            Log::info($data);

            if($query){
                //delete prevDoc

                $fullPath = 'app/public/dokumen/summon/'.$query->doc_name;

                Log::info(storage_path($fullPath));
                if(file_exists(storage_path($fullPath))){
                    unlink(storage_path($fullPath));
                }
                $query->update($data);
                return $id;
            } else {
                return SummonDocument::create($data)->id;
            }
        }
    }

    public function storeSummonDocument($data)
    {
        $summon = MaklumatKenderaanSaman::find($data['id']);

        $document = $summon->dokumenSaman()->create([
            'name_dokumen' => $data['original_name'],
            'path_dokumen' => $data['document_path']
        ]);

        Session::flash('message', 'Berjaya Di Muat Naik');

        return [
            'status' => 'success'
        ];
    }

    public function completionCheck($data)
    {
        $summon = MaklumatKenderaanSaman::find($data);

        if(!empty($summon)){

            if(!empty($summon->maklumatSaman)){

                if(!empty($summon->dokumenSaman))
                {

                    $response = [
                        'status' => 200,
                        'message' => 'All complete'
                    ];

                }else{

                    $response = [
                        'status' => 400,
                        'message' => 'Sila upload dokumen saman'
                    ];

                }
            }else{

                $response = [
                    'status' => 400,
                    'message' => 'Sila lengkapkan maklumat saman'
                ];

            }

        }

        $this->submit($data);

        return $response;
    }

    public function submit($id)
    {
        $saman = MaklumatKenderaanSaman::find($id);

        $update = $saman->update([
            'status_saman_id' => 2
        ]);
    }
}
