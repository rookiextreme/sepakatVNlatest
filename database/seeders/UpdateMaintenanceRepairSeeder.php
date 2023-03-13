<?php

namespace Database\Seeders;

use App\Http\Controllers\PikatMigration\PenilaianDAO;
use App\Http\Controllers\User\UserDAO;
use App\Models\JVPPemohonMigrate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateMaintenanceRepairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        //$listMigrate = JVPPemohonMigrate::all();

        // $listMigrate = DB::connection('pgsql_jvp')->select('select * from "public".pemohon limit 100');
        $listMigrate = DB::connection('pgsql_jvp_public')->select('select * from "public".permohonan where (kod_status = 4 or kod_status = 5) and kod_penilaian = 5   ');

        ini_set('memory_limit', '512M');

        foreach ($listMigrate as $key) {

            $nokp = $key->nokp ;
            $kod_penilaian = $key->kod_penilaian ;
            $trkh_masuk = $key->trkh_masuk ;
            $kod_waran_pej = $key->kod_waran_pej ;
            $kod_status = $key->kod_status ; //kod_status (4-selesai 5-arkib)



            $Penilaian  = new PenilaianDAO();
            $Penilaian->createAssessmentLupus($key);


        }

    }
}
