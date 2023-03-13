<?php

namespace Database\Seeders;

use App\Models\Fleet\FleetProject;
use App\Models\Fleet\FleetPublic;
use App\Models\FleetDisposal;
use App\Models\FleetPlacement;
use App\Models\Identifier\KenderaanStatus;
use App\Models\KenderaanLupusMigrate;
use App\Models\KenderaanProjekMigrate;
use App\Models\Location\Negeri;
use App\Models\Location\Placement;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefState;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefVehicleStatus;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FleetProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMigrate = KenderaanProjekMigrate::all();
        // $listMigrate = KenderaanProjekMigrate::limit(50)->get();

        ini_set('memory_limit', '512M');

        foreach ($listMigrate as $key) {

            $negeri = ltrim($key->negeri);
            $negeri = rtrim($negeri);

            $state = RefState::select('id', 'desc')->whereRaw("upper('desc') LIKE '%".$negeri."%' ")
                ->first();

            $stateId = null;
            if (!empty($state)) {
                $stateId = $state->id;
            } else {

                if (strtoupper($negeri) == 'W.P. LABUAN') {
                    $search = 'Wilayah Persekutuan Labuan';
                    $state = RefState::select('id', 'desc')->whereRaw("upper('desc') = '".strtoupper($search)."' ")
                        ->first();
                    $stateId = $state->id;
                }
            }


            $pemilik = $key->pemilik;
            $owner_cawangan = null;
            if(!empty($stateId)){
            $owner_cawangan = RefOwner::select('id','name')->whereRaw("upper(name) like '".$pemilik."%'")
            ->first();
            }

            // $lokasi_penempatan = $key->lokasipenempatan;
            // $placement = FleetPlacement::select('id','name')->whereRaw("upper(name) ='".$lokasi_penempatan."' ")
            // ->first();
            $lokasi_penempatan = $key->lokasipenempatan;

            $lokasi_penempatan = str_replace('PARKIR', '', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKMN NEGERI SEMBILAN', 'CAWANGAN KEJURUTERAAN MEKANIKAL NEGERI SEMBILAN', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKM NEGERI SEMBILAN', 'CAWANGAN KEJURUTERAAN MEKANIKAL NEGERI SEMBILAN', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKE NEGERI SEMBILAN', 'CAWANGAN KEJURUTERAAN ELEKTRIK NEGERI SEMBILAN', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CPAB NEGERI SEMBILAN', 'CAWANGAN PENGURUSAN ASET BERSEPADU NEGERI SEMBILAN', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKMN', 'CAWANGAN KEJURUTERAAN MEKANIKAL NEGERI', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKM', 'CAWANGAN KEJURUTERAAN MEKANIKAL NEGERI', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKE', 'CAWANGAN KEJURUTERAAN ELEKTRIK NEGERI', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('UNIT TENTERA JKR', 'UNIT TENTERA JKR NEGERI', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CPAB', 'CAWANGAN PENGURUSAN ASET BERSEPADU NEGERI', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('KEM TENTERA', 'UNIT TENTERA', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKP', 'IBU PEJABAT CAWANGAN KERJA PENDIDIKAN', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('WSP', 'WOKSYOP PERSEKUTUAN', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('CKK', 'IBU PEJABAT CAWANGAN KERJA KESELAMATAN', $lokasi_penempatan);

            $placement = FleetPlacement::select('id','desc')->whereRaw("upper(\"desc\") ='".ltrim($lokasi_penempatan)."' ")
            ->first();

            $kategori = $key->kategori;
            if($kategori == 'KENDERAAN'){
                $kategori = 'KENDERAAN PENUMPANG';
            }
            $category = RefCategory::select('id','name')->whereRaw("upper(name) ='".$kategori."' ")
            ->first();

            $sub_kategori = $key->subkategori;
            $sub_category = RefSubCategory::select('id','name')->whereRaw("upper(name) ='".$sub_kategori."' ")
            ->first();

            $jenis = $key->jenis;
            $sub_category_type = RefSubCategoryType::select('id','name')->whereRaw("upper(name) ='".$jenis."' ")
            ->first();

            $brandName = $key->pembuat;
            $vehicleBrand = Brand::select('id','name')->whereRaw("upper(name) ='".$brandName."' ")
            ->first();

            $modelName = $key->model;
            $vehicleModel = VehicleModel::select('id','name')->whereRaw("upper(name) ='".$modelName."' ")
            ->first();

            $hakmilik = $key->hakmilik;
            $hakmilik = str_replace('KONTRAKTOR', 'PROJEK', $hakmilik);
            $ownerType = RefOwnerType::select('id','desc_bm')->whereRaw("upper(\"desc_bm\") LIKE '%".$hakmilik."%'")
            ->where([
                'display_for' => 'vehicle_register'
            ])->first();
            if(!empty($ownerType)){
                $ownerTypeId = $ownerType->id;
            }else{
                $ownerTypeId = null ;
            }


            $tarikhmula = $key->tarikhmula;
            $tarikhmula = str_replace('.', '-', $tarikhmula);
            Log::info("tarikhmula>>. ".$key->tarikhmula);

            $tarikhsiap = $key->tarikhsiap;
            $tarikhsiap = str_replace('.', '-', $tarikhsiap);

            $tarikhcpc = $key->tarikhcpc;
            $tarikhcpc = str_replace('.', '-', $tarikhcpc);

            $project_id = FleetProject::create([
                'contract_no' => $key->nokontrak,
                'project_name' => $key->namaprojek,
                'hopt' => $key->hopt,
                'contractor_name' => $key->namasyarikat,
                'project_start_dt' => $key->tarikhmula ? Carbon::parse($tarikhmula )->format('Y-m-d') : null,
                'project_end_dt' => $key->tarikhsiap ? Carbon::parse($key->tarikhsiap)->format('Y-m-d') : null,
                'project_cpc_dt' => $key->tarikhcpc ? Carbon::parse($key->tarikhcpc)->format('Y-m-d') : null,
            ])->id;

            $vAppStatus = KenderaanStatus::where('code', '06')->first();
            $vehicleStatus = RefVehicleStatus::where('code', '01')->first();
            $pendaftaran_id = FleetPublic::create([

                'state_id' => $stateId,
                'cawangan_id' => $owner_cawangan ? $owner_cawangan->id : null,
                'placement_id' => $placement ? $placement->id : null,
                'no_pendaftaran' => $key->nopendaftaran,
                'owner_type_id' => $ownerTypeId,
                'no_jkr' => $key->nojkr,
                'vapp_status_id' => $vAppStatus->id,
                'category_id' => $category ? $category->id : null,
                'sub_category_id' => $sub_category ? $sub_category->id : null,
                'sub_category_type_id' => $sub_category_type ? $sub_category_type->id : null,
                'brand_id' => $vehicleBrand ? $vehicleBrand->id : null,
                'model_id' => $vehicleModel ? $vehicleModel->id : null,
                'no_chasis' => $key->nochasis,
                'no_engine' => $key->noenjin,
                'vehicle_status_id' => $vehicleStatus->id,
                'project_id' => $project_id

                // 'pembeli' => $key->pembelipenerima
                // 'cawangan_id',
                // 'no_id_pemunya',
                // 'pic_name',
                // 'pic_email',
                // 'status',
                // 'tarikh_belian',
                // 'no_resit',
                // 'vapp_status_id',
                // 'comment',
                // 'created_by',
                // 'created_at',
                // 'updated_at'
            ])->id;




        }
    }
}
