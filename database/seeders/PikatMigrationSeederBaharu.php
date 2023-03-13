<?php

namespace Database\Seeders;

use App\Http\Controllers\PikatMigration\PenilaianDAO;
use App\Http\Controllers\User\UserDAO;
use App\Models\JVPPemohonMigrate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PikatMigrationSeederBaharu extends Seeder
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
        $listMigrate = DB::connection('pgsql_jvp_public')->select('select * from "public".permohonan where (kod_status = 4 or kod_status = 5) and kod_penilaian = 1  ');

        ini_set('memory_limit', '512M');

        foreach ($listMigrate as $key) {

            // $nama_pemohon = $key->nama_pemohon ;
            // $email = $key->email ;
            // $nokp = $key->nokp ;
            // $no_tel_bimbit = $key->no_tel_bimbit ;
            // Log::info("Name : ".$key->nama_pemohon);
            //  $UserDAO = new UserDAO();
            //  $UserDAO->createUserPublic('Administrator','yusman','admin@spakat.com', 'asdqwe123', '01', 'is_jkr', '0123456789');

            $nokp = $key->nokp ;
            $kod_penilaian = $key->kod_penilaian ;
            $trkh_masuk = $key->trkh_masuk ;
            $kod_waran_pej = $key->kod_waran_pej ;
            $kod_status = $key->kod_status ; //kod_status (4-selesai 5-arkib)



            $Penilaian  = new PenilaianDAO();
            $Penilaian->createAssessment($key);


        }

    }
}
