<?php

namespace Database\Seeders;

use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\JVPMaklumatKenderaanMigrate;
use App\Models\JVPMaklumatPenilaianMigrate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PDO;

class PatchAssessmentNewForemenDate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ini_set('memory_limit', '512M');

        $query = AssessmentNewVehicle::whereHas('hasAssessmentDetail', function($q){
            $q->where('is_migrate', true);
        })->whereNull('foremen_dt')->get();

        foreach ($query as $index => $key) {

            $plateno = str_replace(' ', '', Str::upper($key->plate_no));
            Log::info($plateno);

            $tableJVPMaklumatKenderaanMigrate = new JVPMaklumatKenderaanMigrate();
            $tableJVPMaklumatKenderaanMigrate->setConnection('pgsql');
            $mkenderaan = $tableJVPMaklumatKenderaanMigrate->setTable('migrate.maklumat_kenderaan')->select('id_maklumat_kend',DB::raw('upper(replace(no_pendaftaran_kend, \' \', \'\'))'),'no_enjin','no_chasis','no_pesanan_kerajaan','kod_pembuat','id_model')
            ->whereRaw('upper(replace(no_pendaftaran_kend, \' \', \'\')) = \''.$plateno.'\'')
            ->orderBy('id_permohonan')
            ->first();

            $id_maklumat_kend = null;
            if($mkenderaan && $mkenderaan->id_maklumat_kend) {
                $id_maklumat_kend = $mkenderaan->id_maklumat_kend;
            }

            $tableJVPMaklumatPenilaianMigrate = new JVPMaklumatPenilaianMigrate();
            $tableJVPMaklumatPenilaianMigrate->setConnection('pgsql');
            $pemeriksa = $tableJVPMaklumatPenilaianMigrate->setTable('migrate.penilaian')->select('periksa_oleh','trkh_periksa')->where('id_maklumat_kend', $id_maklumat_kend)
            ->first();

            $data = [
                'foremen_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL,
                'assessment_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL
            ];

            $foremen_by = null;

            if($pemeriksa && $pemeriksa->periksa_oleh){
                $foremen_by = User::where('username', $pemeriksa->periksa_oleh)->first();
                if($foremen_by){
                    Log::info($foremen_by);
                    $data['foremen_by'] = $foremen_by->id;
                }
            }

            $key->update($data);
        }

    }
}
