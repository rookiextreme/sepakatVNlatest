<?php

namespace App\Console\Commands\summon;

use App\Mail\Scheduler\SchedulerSummonNotification;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Saman\MaklumatKenderaanSaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Query
{

    public function summonInfo(){
        $summonPayUrl = route('vehicle.saman.rekodbayar');

        $table = new FleetLookupVehicle();
        $table->setTable('fleet.fleet_lookup_vehicle_view AS a');

        $vehicleList = $table->select(
            'a.id AS vehicle_id')
        ->join('saman.maklumat_kenderaan_saman AS b', 'b.pendaftaran_id', 'a.id')
        ->join('saman.maklumat_saman AS c', 'c.maklumat_kenderaan_saman_id', 'b.id')
        ->join('saman.status_saman AS d', 'd.id', 'b.status_saman_id')
        ->whereRaw('(c.pic_email1 IS NOT NULL OR c.pic_email2 IS NOT NULL) AND d.code in (\'02\')')
        ->groupBy('a.id')
        ->get();

        $emails = [];

        foreach ($vehicleList as $vehicle) {

            $MaklumatKenderaanSaman = MaklumatKenderaanSaman::where('pendaftaran_id', $vehicle->vehicle_id)->latest()->first();

            Log::info($MaklumatKenderaanSaman->maklumatSaman);

            if($MaklumatKenderaanSaman->maklumatSaman->pic_email1){
                array_push($emails, $MaklumatKenderaanSaman->maklumatSaman->pic_email1);
            }
            if($MaklumatKenderaanSaman->maklumatSaman->pic_email2){
                array_push($emails, $MaklumatKenderaanSaman->maklumatSaman->pic_email2);
            }

            $summonList = DB::select("
                select b.summon_notice_no from saman.maklumat_kenderaan_saman a
                JOIN saman.maklumat_saman b ON b.maklumat_kenderaan_saman_id = a.id
                JOIN saman.status_saman c ON c.id = a.status_saman_id
                WHERE a.pendaftaran_id = ".$vehicle->vehicle_id." and c.code in ('02') ");

            $emailBody = [
                'subject' => 'Maklumat Saman Kenderaan',
                'title' => 'Maklumat Saman Kenderaan',
                'plat_no' => $MaklumatKenderaanSaman->pendaftaran->no_pendaftaran,
                'summon_total' => count($summonList),
                'summonList' => $summonList,
                'url' =>  Route('.redirect').'?redirectTo='.$summonPayUrl
            ];

            Log::info($emails);

            Mail::to($emails)->send(new SchedulerSummonNotification($emailBody));

        }

        Log::info('Run Scheduler for Summon');
    }

}