<?php

namespace Database\Seeders;

use App\Models\RefTypeAnnouncement;
use App\Models\SettingAnnouncement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingAnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //SettingAnnouncement
        $queryRefTypeAnnounce01 = RefTypeAnnouncement::where('code', '01')->first();
        $data = [
            [
                'title_bm' => 'Waktu Operasi Careline Sepanjang PKP',
                'title_en' => 'Waktu Operasi Careline Sepanjang PKP',
                'desc_bm_1' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_bm_2' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_en_1' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_en_2' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'start_dt' => Carbon::now()->format('Y-m-d'),
                'end_dt' => null,
                'type_announce_id' => $queryRefTypeAnnounce01->id,
                'created_by' =>  1,
                'status' => 1,
            ],
            [
                'title_bm' => 'Waktu Operasi Careline Sepanjang PKP',
                'title_en' => 'Waktu Operasi Careline Sepanjang PKP',
                'desc_bm_1' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_bm_2' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_en_1' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_en_2' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'start_dt' => Carbon::now()->format('Y-m-d'),
                'end_dt' => null,
                'type_announce_id' => $queryRefTypeAnnounce01->id,
                'created_by' =>  1,
                'status' => 1,
            ],
            [
                'title_bm' => 'Permohonan Ditutup',
                'title_en' => 'Permohonan Ditutup',
                'desc_bm_1' => 'Nunc feugiat elit a dui consectetur pharetra.',
                'desc_bm_2' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_en_1' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'desc_en_2' => 'Waktu operasi Careline adalah 8.00am - 12.00pm (Isnin-Jumaat) Sebarang urusan rasmi dengan kementrian sila hubungi menerusi email di direktori pegawai',
                'start_dt' => Carbon::now()->format('Y-m-d'),
                'end_dt' => null,
                'type_announce_id' => $queryRefTypeAnnounce01->id,
                'created_by' =>  1,
                'status' => 1,
            ]
        ];

        SettingAnnouncement::insert($data);
    }
}
