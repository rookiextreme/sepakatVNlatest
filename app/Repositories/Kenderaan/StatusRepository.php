<?php

namespace App\Repositories\Kenderaan;

use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\Kenderaan\StatusSemakan;

class StatusRepository
{
    const HAPUS = '00';
    const DRAF = '01';
    const MENUNGGU_SEMAKAN = '02';
    const MENUNGGU_PENGESAHAN = '03';
    const DITOLAK = '04';
    const TIDAK_LENGKAP = '05';
    const SELESAI = '06';


    public function submitionCheck($id)
    {   
        $kenderaan = Pendaftaran::find($id);
        
        if(!empty($kenderaan->maklumat))
        {
            if(!empty($kenderaan->maklumatTambahan))
            {
                if(!empty($kenderaan->dokumen))
                {

                   $response = $this->dokumenCheck($kenderaan);

                }else{

                    $response = [
                        'status' => 400,
                        'message' => 'Sila muat naik dokumen kenderaan'
                    ];
                }

            }else{

                $response = [
                    'status' => 400,
                    'message' => 'Isikan maklumat tambahan kenderaan'
                ];

            }
            
        }else{

            $response = [
                'status' => 400,
                'message' => 'Isikan maklumat kenderaan'
            ];
        }

        return $response;
    }

    public function dokumenCheck($kenderaan)
    {
        if($kenderaan->maklumat->status == 'lupus')
        {
            if(count($kenderaan->dokumen) >= 5 )
            {

                $response = [
                    'status' => 200,
                    'submition' => true
                ];

            }else{

                $response = [
                    'status' => 400,
                    'message' => 'Dokumen tidak lengkap'
                ];

            }
        }else{

            if(count($kenderaan->dokumen) <= 3 )
            {
                $response = [
                    'status' => 200,
                    'submition' => true
                ];

            }else{

                $response = [
                    'status' => 400,
                    'message' => 'Dokumen tidak mencukupi'
                ];

            }
        }

        return $response;
    }

    public function kenderaanStatus($const)
    {
        $status = KenderaanStatus::where('code',$const)->first();

        return $status->id;
    }

    public function createStatus($pendaftaran)
    {
        //Create status after saving draf
        $status = $pendaftaran->statusSemakan()->create([
            'vapp_status_id' => $this->kenderaanStatus($this::DRAF)
        ]);
    }

    public function registerSubmit($id)
    {
        $status = StatusSemakan::where('pendaftaran_id', $id)->first();

        $status->update([
            'vapp_status_id' => 2
        ]);

        return [
            'status' => 200
        ];
    }
}
