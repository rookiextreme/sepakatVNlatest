<?php

namespace App\Repositories\Kenderaan;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetPublic;
use App\Models\Kenderaan\Dokumen;
use App\Models\Kenderaan\Maklumat;
use App\Models\Kenderaan\MaklumatTambahan;
use App\Models\Kenderaan\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use League\CommonMark\Block\Element\Document;

class PendafaranRepository
{
    public function pendaftaran($data)
    {
        $status = new StatusRepository();

        $user = auth()->user();

        // $reg = Pendaftaran::where('no_pendaftaran', $data['no_pendaftaran'])->first();
            
        $daftar = $user->pendaftaran()->create($data);

        $status->createStatus($daftar);

        return [
            'pendaftaran_id' =>  $daftar->id
        ];
    
    }

    public function updateData($data, $currentId)
    {
        $user = auth()->user();
        $pendaftaran = Pendaftaran::find($currentId);
        Log::info($pendaftaran);
        $pendaftaran->update($data);
        return [
            'pendaftaran_id' =>  $pendaftaran->id
        ];
    }

    public function kenderaan($data)
    {
        $pendaftaran = Pendaftaran::find($data['pendaftaran_id']);

        Log::info('after masssage');
        log::info($data);

        Log::info('ada data x ?');
        Log::info($pendaftaran->maklumat);

        if($pendaftaran->maklumat){
            if($data['v_primary_image']){
                $queryUnsetDoc = Dokumen::where('id', '!=', $data['v_primary_image']);
                $queryUnsetDoc->update([
                    'is_primary' => false
                ]);
                $queryDoc = Dokumen::where('id', $data['v_primary_image'])->first();
                Log::info($queryDoc);
                $queryDoc->update([
                    'is_primary' => true
                ]);
            }
            unset($data['v_primary_image']);
            $pendaftaran->maklumat()->update($data);
        } else{
            $pendaftaran->maklumat()->create($data);
        }

        return [
            'status' => 200,
            'message' => 'Maklumat kenderaan berjaya disimpan'
        ];
       
    }

    public function tambahan($data, $isEdit, $currentId)
    {
        
        $reg = Pendaftaran::find($currentId);

        if($reg->maklumatTambahan){
            $data['updated_by'] = auth()->user()->id;

            Log::info('masuk update');
            Log::info($data);

            $reg->maklumatTambahan()->update($data);
        }else{
            $data['created_by'] = auth()->user()->id;

            Log::info('masuk insert');
            Log::info($data);

            $reg->maklumatTambahan()->create($data);
        }

        return [
            'status' => 200,
            'message' => 'Maklumat tambahan berjaya disimpan'
        ];
    }

    public function vehicleImage($data)
    {

        Log::info('vehicleImage');
        Log::info($data);
        $fleetView = $data['fleetView'];
        switch ($fleetView ) {
            case 'department':
                $reg = FleetDepartment::find($data['id']);
                break;
            case 'public':
                $reg = FleetPublic::find($data['id']);
                break;
        }

        $doc = $reg->hasManyDocument();

        Log::info($data['kenderaan']);

        $doc->create($data['kenderaan']);

        return [
            'status' => 200,
            'message' => 'Dokumen berjaya dimuat naik'
        ];
    }

    public function dokumen($data)
    {
        $reg = Pendaftaran::find($data['pendaftaran_id']);

        $doc = $reg->dokumen();

        if(count($data) <= 4) {

            if(isset($data['kewpa3'])){
                $doc->create($data['kewpa3']);
            }
            if(isset($data['geran'])){
                $doc->create($data['geran']);
            }


        }else{

            $doc->create($data['kewpa13']);
            $doc->create($data['kewpa23']);
            $doc->create($data['suratPermohonan']);
            $doc->create($data['resitJualan']);
            
        }

        return [
            'status' => 200,
            'message' => 'Dokumen berjaya dimuat naik'
        ];
    }
}
