<?php

namespace Database\Seeders;

use App\Models\FleetDisposal;
use App\Models\FleetPlacement;
use App\Models\Identifier\KenderaanStatus;
use App\Models\KenderaanLupusMigrate;
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

class FleetDisposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$listMigrate = KenderaanLupusMigrate::limit(50)->get();
        if(env('SMALL_MIGRATE')){
            $listMigrate = KenderaanLupusMigrate::limit(50)->get();
        } else {
            $listMigrate = KenderaanLupusMigrate::all();
        }

        ini_set('memory_limit', '512M');

        foreach ($listMigrate as $key) {

            $negeri = ltrim($key->negeri);
            $negeri = rtrim($negeri);

            $state = RefState::select('id', 'desc')->whereRaw("upper(\"desc\") LIKE '%".$negeri."%' ")
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

            // $pemilik = $key->pemilik;
            // $owner = RefOwner::select('id','name')->whereRaw("upper(name) ='".$pemilik."' ")
            // ->first();

            $lokasi_penempatan = $key->lokasipenempatan;
            Log::info("Before>>".$lokasi_penempatan);
            $lokasi_penempatan = str_replace('PARKIR KEM GONG GEDAK', 'KEM GONG KEDAK', $lokasi_penempatan);
            $lokasi_penempatan = str_replace('PARKIR JKR KUARI BUKIT BULOH', 'JKR KUARI PUSAT BUKIT BULOH', $lokasi_penempatan);
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
            $lokasi_penempatan = str_replace('JKR NEGERI', 'JABATAN KERJA RAYA NEGERI', $lokasi_penempatan);
            Log::info("After>>".ltrim($lokasi_penempatan));
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

            $pemilik = $key->pemilik;
            $pemilik = str_replace('JKR NEGERI', 'JABATAN KERJA RAYA NEGERI', $pemilik);
            if(!empty($stateId)){
            $owner_cawangan = RefOwner::select('id','name')->whereRaw("upper(name) like '".$pemilik."%'")
            ->first();
            }

            // if ($key->hakmilik == 'PERSEKUTUAN'){
            //     $hakmilikSmall = 'persekutuan';
            // } else if ($key->hakmilik == 'NEGERI'){
            //     $hakmilikSmall = 'negeri';
            // } else if ($key->hakmilik == 'KONTRAKTOR (PROJEK)'){
            //     $hakmilikSmall = 'projek';
            // }
            $hakmilik = $key->hakmilik;
            $ownerType = RefOwnerType::select('id','desc_bm')->whereRaw("upper(\"desc_bm\") LIKE '%".$hakmilik."%'")
            ->where([
                'display_for' => 'vehicle_register'
            ])->first();
            if(!empty($ownerType)){
                $ownerTypeId = $ownerType->id;
            }


            // Log::info("1111>>. ".$stateId);
            // Log::info("2222>>. ".$placement);
            // Log::info("333>>. ".$key->nopendaftaran);
            // Log::info("4444>>. ".$key->hakmilik);
            // Log::info("5555>>. ".$key->no_jkr);
            // Log::info("666>>. ".$kategori);
            // Log::info("7777>>. ".$sub_kategori);
            $vAppStatus = KenderaanStatus::where('code', '06')->first();
            $vehicleStatus = RefVehicleStatus::where('code', '04')->first();
            $pendaftaran_id = FleetDisposal::create([

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
                // 'acqDt' => Carbon::parse($key->tarikhperolehan)->format('Y-m-d'),
                // 'harga_perolehan' => bcadd($key->hargaperolehan,'0',2)
                // 'harga_perolehan' => $key->hargaperolehan

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
