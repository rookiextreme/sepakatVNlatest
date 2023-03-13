<?php

namespace App\Http\Controllers\PikatMigration;

use App\Http\Controllers\Helpers\HelpersFunction;
use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentDisposalVehicle;
use App\Models\Assessment\AssessmentGovLoan;
use App\Models\Assessment\AssessmentGovLoanVehicle;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\JVPMaklumatKenderaanMigrate;
use App\Models\JVPMaklumatPenilaianMigrate;
use App\Models\JVPPemohonMigrate;
use App\Models\RefAgency;
use App\Models\RefRole;
use App\Models\RefState;
use App\Models\RefStatus;
use App\Models\RefWorkshop;
use App\Models\User;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PenilaianDAO
{
    public function refRole($code)
    {
        $query = RefRole::where('code', $code)->first();
        return $query->id;
    }

    private function generateRefNumber($table){
        $year = Carbon::now()->format('Y');
        $query = $table::orderBy('created_at', 'desc')->whereHas('hasStatus', function($q){
            $q->whereNotIn('code', ['00','06']);
        });
        if($query->first()){
            $baseYear = Carbon::parse($query->first()->created_at)->format('Y');
        } else {
            $baseYear = Carbon::now()->format('Y');
        }

        $modulePrefix = 'MN'; //Module Penilaian
        $SubModulePrefix = 'B'; //Kenderaan Baharu

        $diffYear = $year-$baseYear;
        $HelpersFunction = new HelpersFunction();
        $alpha = $HelpersFunction->getAlpha($diffYear);

        $workShop = RefWorkshop::find(1);
        $applicationRunningNo = str_pad(((int)$query->count() +1), 4, '0', STR_PAD_LEFT);

        return $modulePrefix.$SubModulePrefix.$alpha.$workShop->code.$applicationRunningNo;
    }

    public function createAssessment($key){

         // $nama_pemohon = $key->nama_pemohon ;
            // $email = $key->email ;
            // $nokp = $key->nokp ;
            // $no_tel_bimbit = $key->no_tel_bimbit ;
            // Log::info("Name : ".$key->nama_pemohon);

          $nokp = $key->nokp;
          $pemohon = JVPPemohonMigrate::select('nama_pemohon','email','no_tel_bimbit','alamat_agensi')->whereRaw("upper(nokp) ='".Str::upper($nokp)."' ")
          ->first();

          $id_permohonan = $key->id_permohonan;
          $mkenderaan = JVPMaklumatKenderaanMigrate::select('id_maklumat_kend','no_pendaftaran_kend','no_enjin','no_chasis','no_pesanan_kerajaan','kod_pembuat','id_model')->whereRaw("id_permohonan ='".$id_permohonan."' ")
          ->first();

          $pemeriksa = JVPMaklumatPenilaianMigrate::select('periksa_oleh','trkh_periksa')->where('id_maklumat_kend', $mkenderaan->id_maklumat_kend)
          ->first();

          $kod_waran_pej = $key->kod_waran_pej;
          $workshop = RefWorkshop::whereRaw("code_warrant_ofs ='".$kod_waran_pej."' ")
          ->first();

          $temujanji = DB::connection('pgsql_jvp_public')->select('select * from temujanji where id_permohonan = '.$id_permohonan);

          Log::info($temujanji);

          $kod_status = $key->kod_status;
          if($kod_status==4 || $kod_status==5){
              $app_status=9;
          }
          Log::info('No_permohonan: '.$key->id_permohonan);
          Log::info('1: '.$pemohon->nama_pemohon);
          Log::info('2: '.$pemohon->no_tel_bimbit);
          Log::info('3: '.$pemohon->nokp);
          Log::info('3: '.$key->nokp);
          Log::info('4: '.$pemohon->email);
          Log::info('5: '.$pemohon->alamat_agensi);
          Log::info('6: '.$key->agensi_lain);
        //   Log::info('7: '.$workshop->id);
          Log::info('8 kod_waran_pej>> '.$kod_waran_pej);

        if(Str::upper($pemohon->nama_pemohon) != 'TEST')  {
        $inserted = AssessmentNew::create([
            'ref_number' => $this->generateRefNumber(AssessmentNew::class),
            'applicant_name' => strtoupper($pemohon->nama_pemohon),
            'phone_no' => $pemohon->no_tel_bimbit ? $pemohon->no_tel_bimbit : '-',
            'ic_no' => $key->nokp ? $key->nokp : '-',
            'email' => $pemohon->email ? $pemohon->email : '-',
            'address' => $pemohon->alamat_agensi ? $pemohon->alamat_agensi : '-',
            'postcode' => '-',
            'bpk_id' => NULL,
             'state_id' => 12,
            'department_name' => $key->agensi_lain ? $key->agensi_lain : '-',
            'appointment_dt1' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
            'appointment_dt2' => NULL,
            'appointment_dt3' => NULL,
            'appointment_dt' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
            'is_other_app_dt' => false,
            'ttl_draf' => 0,
            'ttl_appointment' => 0,
            'ttl_assess' => 0,
            'ttl_evaluate' => 0,
            'ttl_approve' => 0,
            'ttl_complete' => 0,
            'ttl_vehicle' => 1,
            'agency_id' => NULL,
            'workshop_id' => $workshop ? $workshop->id :null,
            'app_status_id' => 9,
            'assessed_dt' => NULL,
            'assessed_by' => NULL,
            'evaluated_dt' => NULL,
            'evaluated_by' => NULL,
            'approved_dt' => NULL,
            'approved_by' => NULL,
            'created_by' => 14,
            'updated_by' => NULL,
            'created_at' => '2021-09-22 08:26:51',
            'updated_at' => '2021-09-22 08:38:24',
            'is_migrate' => true
        ]);

        if($mkenderaan != null){

        Log::info('1-vehicle-ID: '.$inserted->id);
        Log::info('1-vehicle: '.$mkenderaan->id_model);
        Log::info('2-vehicle: '.$mkenderaan->tahun_dibuat);
        Log::info('3-vehicle: '.$mkenderaan->trkh_daftar);
        Log::info('4-vehicle: '.$mkenderaan->no_pendaftaran_kend);
        Log::info('5-vehicle: '.$mkenderaan->no_enjin);
        Log::info('6-vehicle: '.$mkenderaan->trkh_beli);
        Log::info('7-vehicle: '.$mkenderaan->nama_syarikat);
        Log::info('8-vehicle: '.$mkenderaan->kod_pembuat);

        if($mkenderaan->kod_pembuat != null){
        $pembuat = DB::connection('pgsql_jvp_public')->select('select nama_pembuat from l_pembuat where kod_pembuat = '.$mkenderaan->kod_pembuat);

        $brandName = $pembuat ? $pembuat[0]->nama_pembuat : null;
        Log::info('NamaPembuat: '.$brandName);

        $vehicleBrand = Brand::select('id','name')->whereRaw("upper(name) ='".Str::upper($brandName)."' ")
        ->first();

        }else{
            $vehicleBrand = null;
        }

        Log::info('IDDDDModel: '.$mkenderaan->id_model);
        if($mkenderaan->id_model != null){
        $model = DB::connection('pgsql_jvp_public')->select('select nama_model from l_model where id_model = '.$mkenderaan->id_model);
        Log::info($model);
        $namamodel = $model ? $model[0]->nama_model : null;
        Log::info('NamaModel: '.$namamodel);
        }else{
            $namamodel = null;
        }


        // $vehicleModel = VehicleModel::select('id','name')->whereRaw("upper(name) ='".$namamodel."' ")
        // ->first();

        AssessmentNewVehicle::create([
            'assessment_new_id' => $inserted->id,
            'vehicle_brand_id' => $vehicleBrand ? $vehicleBrand->id : null,
            'model_name' => $namamodel,
            'manufacture_year' => $mkenderaan->tahun_dibuat ? $mkenderaan->tahun_dibuat : '2000',
            'registration_vehicle_dt' => $mkenderaan->trkh_daftar ? $mkenderaan->trkh_daftar : '2021-09-22 00:00:00',
            'plate_no' => $mkenderaan->no_pendaftaran_kend ? $mkenderaan->no_pendaftaran_kend : '' ,
            'engine_no' => $mkenderaan->no_enjin ? $mkenderaan->no_enjin : '-',
            'chasis_no' => $mkenderaan->no_chasis ? $mkenderaan->no_chasis : '-',
            'purchase_dt' => $mkenderaan->trkh_beli ? $mkenderaan->trkh_beli : '2021-09-22 00:00:00',
            'company_name' => $mkenderaan->nama_syarikat ? $mkenderaan->nama_syarikat : '-' ,
            'assessment_vehicle_status_id' => 7,
            'foremen_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL,
            'assessment_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL
        ])->id;

        }
    }

    }


    public function createAssessmentPinjaman($key){
        // $nama_pemohon = $key->nama_pemohon ;
           // $email = $key->email ;
           // $nokp = $key->nokp ;
           // $no_tel_bimbit = $key->no_tel_bimbit ;
           // Log::info("Name : ".$key->nama_pemohon);

         $nokp = $key->nokp;
         $pemohon = JVPPemohonMigrate::select('nama_pemohon','email','no_tel_bimbit','alamat_agensi')->whereRaw("upper(nokp) ='".Str::upper($nokp)."' ")
         ->first();

         $id_permohonan = $key->id_permohonan;
         $mkenderaan = JVPMaklumatKenderaanMigrate::select('id_maklumat_kend','no_pendaftaran_kend','no_enjin','no_chasis','no_pesanan_kerajaan','kod_pembuat','id_model')->whereRaw("id_permohonan ='".$id_permohonan."' ")
         ->first();

         $pemeriksa = JVPMaklumatPenilaianMigrate::select('periksa_oleh','trkh_periksa')->where('id_maklumat_kend', $mkenderaan->id_maklumat_kend)
          ->first();

         $kod_waran_pej = $key->kod_waran_pej;
         $workshop = RefWorkshop::whereRaw("code_warrant_ofs ='".$kod_waran_pej."' ")
         ->first();

         $temujanji = DB::connection('pgsql_jvp_public')->select('select * from temujanji where id_permohonan = '.$id_permohonan);

         Log::info($temujanji);

         $kod_status = $key->kod_status;
         if($kod_status==4 || $kod_status==5){
             $app_status=9;
         }
         Log::info('No_permohonan: '.$key->id_permohonan);
         Log::info('1: '.$pemohon->nama_pemohon);
         Log::info('2: '.$pemohon->no_tel_bimbit);
         Log::info('3: '.$pemohon->nokp);
         Log::info('3: '.$key->nokp);
         Log::info('4: '.$pemohon->email);
         Log::info('5: '.$pemohon->alamat_agensi);
         Log::info('6: '.$key->agensi_lain);
       //   Log::info('7: '.$workshop->id);
         Log::info('8 kod_waran_pej>> '.$kod_waran_pej);

       if(Str::upper($pemohon->nama_pemohon) != 'TEST')  {
       $inserted = AssessmentGovLoan::create([
           'ref_number' => $this->generateRefNumber(AssessmentGovLoan::class),
           'applicant_name' => strtoupper($pemohon->nama_pemohon),
           'phone_no' => $pemohon->no_tel_bimbit ? $pemohon->no_tel_bimbit : '-',
           'ic_no' => $key->nokp ? $key->nokp : '-',
           'email' => $pemohon->email ? $pemohon->email : '-',
           'address' => $pemohon->alamat_agensi ? $pemohon->alamat_agensi : '-',
           'postcode' => '-',
           'bpk_id' => NULL,
            'state_id' => 12,
           'department_name' => $key->agensi_lain ? $key->agensi_lain : '-',
           'appointment_dt1' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
           'appointment_dt2' => NULL,
           'appointment_dt3' => NULL,
           'appointment_dt' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
           'is_other_app_dt' => false,
           'ttl_draf' => 0,
           'ttl_appointment' => 0,
           'ttl_assess' => 0,
           'ttl_evaluate' => 0,
           'ttl_approve' => 0,
           'ttl_complete' => 0,
           'ttl_vehicle' => 1,
           'agency_id' => NULL,
           'workshop_id' => $workshop ? $workshop->id :null,
           'app_status_id' => 9,
        //    'assessment_dt' => NULL,
        //    'assessment_by' => NULL,
        //    'evaluated_dt' => NULL,
        //    'evaluated_by' => NULL,
        //    'approve_dt' => NULL,
        //    'approve_by' => NULL,
           'created_by' => 14,
           'updated_by' => NULL,
           'created_at' => '2021-09-22 08:26:51',
           'updated_at' => '2021-09-22 08:38:24'
       ]);

       if($mkenderaan != null){

       Log::info('1-vehicle-ID: '.$inserted->id);
       Log::info('1-vehicle: '.$mkenderaan->id_model);
       Log::info('2-vehicle: '.$mkenderaan->tahun_dibuat);
       Log::info('3-vehicle: '.$mkenderaan->trkh_daftar);
       Log::info('4-vehicle: '.$mkenderaan->no_pendaftaran_kend);
       Log::info('5-vehicle: '.$mkenderaan->no_enjin);
       Log::info('6-vehicle: '.$mkenderaan->trkh_beli);
       Log::info('7-vehicle: '.$mkenderaan->nama_syarikat);
       Log::info('8-vehicle: '.$mkenderaan->kod_pembuat);

       if($mkenderaan->kod_pembuat != null){
       $pembuat = DB::connection('pgsql_jvp_public')->select('select nama_pembuat from l_pembuat where kod_pembuat = '.$mkenderaan->kod_pembuat);

       $brandName = $pembuat ? $pembuat[0]->nama_pembuat : null;
       Log::info('NamaPembuat: '.$brandName);

       $vehicleBrand = Brand::select('id','name')->whereRaw("upper(name) ='".Str::upper($brandName)."' ")
       ->first();

       }else{
           $vehicleBrand = null;
       }

       Log::info('IDDDDModel: '.$mkenderaan->id_model);
       if($mkenderaan->id_model != null){
       $model = DB::connection('pgsql_jvp_public')->select('select nama_model from l_model where id_model = '.$mkenderaan->id_model);
       Log::info($model);
       $namamodel = $model ? $model[0]->nama_model : null;
       Log::info('NamaModel: '.$namamodel);
       }else{
           $namamodel = null;
       }


       // $vehicleModel = VehicleModel::select('id','name')->whereRaw("upper(name) ='".$namamodel."' ")
       // ->first();

       AssessmentGovLoanVehicle::create([
           'assessment_gov_loan_id' => $inserted->id,
           'vehicle_brand_id' => $vehicleBrand ? $vehicleBrand->id : null,
           'model_name' => $namamodel ? $namamodel : '',
           'manufacture_year' => $mkenderaan->tahun_dibuat ? $mkenderaan->tahun_dibuat : '2000',
           'registration_vehicle_dt' => $mkenderaan->trkh_daftar ? $mkenderaan->trkh_daftar : '2021-09-22 00:00:00',
           'plate_no' => $mkenderaan->no_pendaftaran_kend ? $mkenderaan->no_pendaftaran_kend : '' ,
           'engine_no' => $mkenderaan->no_enjin ? $mkenderaan->no_enjin : '-',
           'chasis_no' => $mkenderaan->no_chasis ? $mkenderaan->no_chasis : '-',
           'purchase_dt' => $mkenderaan->trkh_beli ? $mkenderaan->trkh_beli : '2021-09-22 00:00:00',
           'company_name' => $mkenderaan->nama_syarikat ? $mkenderaan->nama_syarikat : '-' ,
           'assessment_vehicle_status_id' => 7,
           'foremen_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL,
            'assessment_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL
       ])->id;

       }
   }

   }

   public function createAssessmentLupus($key){


     $nokp = $key->nokp;
     $pemohon = JVPPemohonMigrate::select('nama_pemohon','email','no_tel_bimbit','alamat_agensi')->whereRaw("upper(nokp) ='".Str::upper($nokp)."' ")
     ->first();

     $id_permohonan = $key->id_permohonan;
     $mkenderaan = JVPMaklumatKenderaanMigrate::select('id_maklumat_kend','no_pendaftaran_kend','no_enjin','no_chasis','no_pesanan_kerajaan','kod_pembuat','id_model')->whereRaw("id_permohonan ='".$id_permohonan."' ")
     ->first();

     $pemeriksa = JVPMaklumatPenilaianMigrate::select('periksa_oleh','trkh_periksa')->where('id_maklumat_kend', $mkenderaan->id_maklumat_kend)
     ->first();

     $kod_waran_pej = $key->kod_waran_pej;
     $workshop = RefWorkshop::whereRaw("code_warrant_ofs ='".$kod_waran_pej."' ")
     ->first();

     $temujanji = DB::connection('pgsql_jvp_public')->select('select * from temujanji where id_permohonan = '.$id_permohonan);

     Log::info($temujanji);

     $kod_status = $key->kod_status;
     if($kod_status==4 || $kod_status==5){
         $app_status=9;
     }
     Log::info('No_permohonan: '.$key->id_permohonan);
     Log::info('1: '.$pemohon->nama_pemohon);
     Log::info('2: '.$pemohon->no_tel_bimbit);
     Log::info('3: '.$pemohon->nokp);
     Log::info('3: '.$key->nokp);
     Log::info('4: '.$pemohon->email);
     Log::info('5: '.$pemohon->alamat_agensi);
     Log::info('6: '.$key->agensi_lain);
   //   Log::info('7: '.$workshop->id);
     Log::info('8 kod_waran_pej>> '.$kod_waran_pej);

   if(Str::upper($pemohon->nama_pemohon) != 'TEST')  {
   $inserted = AssessmentDisposal::create([
       'ref_number' => $this->generateRefNumber(AssessmentDisposal::class),
       'applicant_name' => strtoupper($pemohon->nama_pemohon),
       'phone_no' => $pemohon->no_tel_bimbit ? $pemohon->no_tel_bimbit : '-',
       'ic_no' => $key->nokp ? $key->nokp : '-',
       'email' => $pemohon->email ? $pemohon->email : '-',
       'address' => $pemohon->alamat_agensi ? $pemohon->alamat_agensi : '-',
       'postcode' => '-',
    //    'bpk_id' => NULL,
        'state_id' => 12,
       'department_name' => $key->agensi_lain ? $key->agensi_lain : '-',
       'appointment_dt1' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
       'appointment_dt2' => NULL,
       'appointment_dt3' => NULL,
       'appointment_dt' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
       'is_other_app_dt' => false,
       'ttl_draf' => 0,
       'ttl_appointment' => 0,
       'ttl_assess' => 0,
       'ttl_evaluate' => 0,
       'ttl_approve' => 0,
       'ttl_complete' => 0,
       'ttl_vehicle' => 1,
       'agency_id' => NULL,
       'workshop_id' => $workshop ? $workshop->id :null,
       'app_status_id' => 9,
    //    'assessment_dt' => NULL,
    //    'assessment_by' => NULL,
    //    'evaluated_dt' => NULL,
    //    'evaluated_by' => NULL,
    //    'approve_dt' => NULL,
    //    'approve_by' => NULL,
       'created_by' => 14,
       'updated_by' => NULL,
       'created_at' => '2021-09-22 08:26:51',
       'updated_at' => '2021-09-22 08:38:24'
   ]);

   if($mkenderaan != null){

   Log::info('1-vehicle-ID: '.$inserted->id);
   Log::info('1-vehicle: '.$mkenderaan->id_model);
   Log::info('2-vehicle: '.$mkenderaan->tahun_dibuat);
   Log::info('3-vehicle: '.$mkenderaan->trkh_daftar);
   Log::info('4-vehicle: '.$mkenderaan->no_pendaftaran_kend);
   Log::info('5-vehicle: '.$mkenderaan->no_enjin);
   Log::info('6-vehicle: '.$mkenderaan->trkh_beli);
   Log::info('7-vehicle: '.$mkenderaan->nama_syarikat);
   Log::info('8-vehicle: '.$mkenderaan->kod_pembuat);

   if($mkenderaan->kod_pembuat != null){
   $pembuat = DB::connection('pgsql_jvp_public')->select('select nama_pembuat from l_pembuat where kod_pembuat = '.$mkenderaan->kod_pembuat);

   $brandName = $pembuat ? $pembuat[0]->nama_pembuat : null;
   Log::info('NamaPembuat: '.$brandName);

   $vehicleBrand = Brand::select('id','name')->whereRaw("upper(name) ='".Str::upper($brandName)."' ")
   ->first();

   }else{
       $vehicleBrand = null;
   }

   Log::info('IDDDDModel: '.$mkenderaan->id_model);
   if($mkenderaan->id_model != null){
   $model = DB::connection('pgsql_jvp_public')->select('select nama_model from l_model where id_model = '.$mkenderaan->id_model);
   Log::info($model);
   $namamodel = $model ? $model[0]->nama_model : null;
   Log::info('NamaModel: '.$namamodel);
   }else{
       $namamodel = null;
   }


   // $vehicleModel = VehicleModel::select('id','name')->whereRaw("upper(name) ='".$namamodel."' ")
   // ->first();

   AssessmentDisposalVehicle::create([
       'assessment_disposal_id' => $inserted->id,
       'vehicle_brand_id' => $vehicleBrand ? $vehicleBrand->id : null,
       'model_name' => $namamodel ? $namamodel : '',
       'manufacture_year' => $mkenderaan->tahun_dibuat ? $mkenderaan->tahun_dibuat : '2000',
       'registration_vehicle_dt' => $mkenderaan->trkh_daftar ? $mkenderaan->trkh_daftar : '2021-09-22 00:00:00',
       'plate_no' => $mkenderaan->no_pendaftaran_kend ? $mkenderaan->no_pendaftaran_kend : '' ,
       'engine_no' => $mkenderaan->no_enjin ? $mkenderaan->no_enjin : '-',
       'chasis_no' => $mkenderaan->no_chasis ? $mkenderaan->no_chasis : '-',
       'purchase_dt' => $mkenderaan->trkh_beli ? $mkenderaan->trkh_beli : '2021-09-22 00:00:00',
       'company_name' => $mkenderaan->nama_syarikat ? $mkenderaan->nama_syarikat : '-' ,
       'assessment_vehicle_status_id' => 7,
       'original_price' => 0,
       'aset_regno' => '',
       'nc_no' => '',
       'foremen_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL,
        'assessment_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL
   ])->id;

   }
}

}

public function createAssessmentKemalangan($key){


    $nokp = $key->nokp;
    $pemohon = JVPPemohonMigrate::select('nama_pemohon','email','no_tel_bimbit','alamat_agensi')->whereRaw("upper(nokp) ='".Str::upper($nokp)."' ")
    ->first();

    $id_permohonan = $key->id_permohonan;
    $mkenderaan = JVPMaklumatKenderaanMigrate::select('id_maklumat_kend','no_pendaftaran_kend','no_enjin','no_chasis','no_pesanan_kerajaan','kod_pembuat','id_model')->whereRaw("id_permohonan ='".$id_permohonan."' ")
    ->first();

    $pemeriksa = JVPMaklumatPenilaianMigrate::select('periksa_oleh','trkh_periksa')->where('id_maklumat_kend', $mkenderaan->id_maklumat_kend)
     ->first();

    $kod_waran_pej = $key->kod_waran_pej;
    $workshop = RefWorkshop::whereRaw("code_warrant_ofs ='".$kod_waran_pej."' ")
    ->first();

    $temujanji = DB::connection('pgsql_jvp_public')->select('select * from temujanji where id_permohonan = '.$id_permohonan);

    Log::info($temujanji);

    $kod_status = $key->kod_status;
    if($kod_status==4 || $kod_status==5){
        $app_status=9;
    }
    Log::info('No_permohonan: '.$key->id_permohonan);
    Log::info('1: '.$pemohon->nama_pemohon);
    Log::info('2: '.$pemohon->no_tel_bimbit);
    Log::info('3: '.$pemohon->nokp);
    Log::info('3: '.$key->nokp);
    Log::info('4: '.$pemohon->email);
    Log::info('5: '.$pemohon->alamat_agensi);
    Log::info('6: '.$key->agensi_lain);
  //   Log::info('7: '.$workshop->id);
    Log::info('8 kod_waran_pej>> '.$kod_waran_pej);

  if(Str::upper($pemohon->nama_pemohon) != 'TEST')  {
  $inserted = AssessmentAccident::create([
      'ref_number' => $this->generateRefNumber(AssessmentAccident::class),
      'applicant_name' => strtoupper($pemohon->nama_pemohon),
      'phone_no' => $pemohon->no_tel_bimbit ? $pemohon->no_tel_bimbit : '-',
    //   'ic_no' => $key->nokp ? $key->nokp : '-',
      'email' => $pemohon->email ? $pemohon->email : '-',
      'address' => $pemohon->alamat_agensi ? $pemohon->alamat_agensi : '-',
      'postcode' => '-',
   //    'bpk_id' => NULL,
       'state_id' => 12,
      'department_name' => $key->agensi_lain ? $key->agensi_lain : '-',
      'appointment_dt1' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
      'appointment_dt2' => NULL,
      'appointment_dt3' => NULL,
      'appointment_dt' => $temujanji && $temujanji[0]->trkh_temujanji ? $temujanji[0]->trkh_temujanji : NULL,
      'is_other_app_dt' => false,
    //   'ttl_draf' => 0,
    //   'ttl_appointment' => 0,
    //   'ttl_assess' => 0,
    //   'ttl_evaluate' => 0,
    //   'ttl_approve' => 0,
    //   'ttl_complete' => 0,
    //   'ttl_vehicle' => 1,
      'agency_id' => NULL,
      'workshop_id' => $workshop ? $workshop->id :null,
      'app_status_id' => 9,
   //    'assessment_dt' => NULL,
   //    'assessment_by' => NULL,
   //    'evaluated_dt' => NULL,
   //    'evaluated_by' => NULL,
   //    'approve_dt' => NULL,
   //    'approve_by' => NULL,
      'created_by' => 14,
      'updated_by' => NULL,
      'created_at' => '2021-09-22 08:26:51',
      'updated_at' => '2021-09-22 08:38:24',
      'representing' => ''
  ]);

  if($mkenderaan != null){

  Log::info('1-vehicle-ID: '.$inserted->id);
  Log::info('1-vehicle: '.$mkenderaan->id_model);
  Log::info('2-vehicle: '.$mkenderaan->tahun_dibuat);
  Log::info('3-vehicle: '.$mkenderaan->trkh_daftar);
  Log::info('4-vehicle: '.$mkenderaan->no_pendaftaran_kend);
  Log::info('5-vehicle: '.$mkenderaan->no_enjin);
  Log::info('6-vehicle: '.$mkenderaan->trkh_beli);
  Log::info('7-vehicle: '.$mkenderaan->nama_syarikat);
  Log::info('8-vehicle: '.$mkenderaan->kod_pembuat);

  if($mkenderaan->kod_pembuat != null){
  $pembuat = DB::connection('pgsql_jvp_public')->select('select nama_pembuat from l_pembuat where kod_pembuat = '.$mkenderaan->kod_pembuat);

  $brandName = $pembuat ? $pembuat[0]->nama_pembuat : null;
  Log::info('NamaPembuat: '.$brandName);

  $vehicleBrand = Brand::select('id','name')->whereRaw("upper(name) ='".Str::upper($brandName)."' ")
  ->first();

  }else{
      $vehicleBrand = null;
  }

  Log::info('IDDDDModel: '.$mkenderaan->id_model);
  if($mkenderaan->id_model != null){
  $model = DB::connection('pgsql_jvp_public')->select('select nama_model from l_model where id_model = '.$mkenderaan->id_model);
  Log::info($model);
  $namamodel = $model ? $model[0]->nama_model : null;
  Log::info('NamaModel: '.$namamodel);
  }else{
      $namamodel = null;
  }


  // $vehicleModel = VehicleModel::select('id','name')->whereRaw("upper(name) ='".$namamodel."' ")
  // ->first();

  AssessmentAccidentVehicle::create([
      'assessment_accident_id' => $inserted->id,
      'vehicle_brand_id' => $vehicleBrand ? $vehicleBrand->id : null,
      'model_name' => $namamodel ? $namamodel : '',
      'manufacture_year' => $mkenderaan->tahun_dibuat ? $mkenderaan->tahun_dibuat : '2000',
      'registration_vehicle_dt' => $mkenderaan->trkh_daftar ? $mkenderaan->trkh_daftar : '2021-09-22 00:00:00',
      'plate_no' => $mkenderaan->no_pendaftaran_kend ? $mkenderaan->no_pendaftaran_kend : '' ,
      'engine_no' => $mkenderaan->no_enjin ? $mkenderaan->no_enjin : '-',
      'chasis_no' => $mkenderaan->no_chasis ? $mkenderaan->no_chasis : '-',
      'purchase_dt' => $mkenderaan->trkh_beli ? $mkenderaan->trkh_beli : '2021-09-22 00:00:00',
      'company_name' => $mkenderaan->nama_syarikat ? $mkenderaan->nama_syarikat : '-' ,
      'assessment_vehicle_status_id' => 7,
      'foremen_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL,
        'assessment_dt' => ($pemeriksa && $pemeriksa->trkh_periksa) ? $pemeriksa->trkh_periksa : NULL
    //   'original_price' => 0,
    //   'aset_regno' => '',
    //   'nc_no' => ''
  ])->id;

  }
}

}

    public function createUserAdmin($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit){

        // $user = User::create([
        //     'name' => strtoupper($name),
        //     'username' => $username,
        //     'email' => $email,
        //     'password' =>  Hash::make($password)
        // ]);

        // $user->assignRole('01');

        // $user->detail()->create([
        //     'user_id' => $user->id,
        //     'ref_status_id' => $this->refStatus('06'),
        //     'ref_role_id' => $this->refRole('01'),
        //     'register_purpose' => $register_purpose,
        //     'telbimbit' => $telbimbit,
        //     'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        // ]);
    }



}
