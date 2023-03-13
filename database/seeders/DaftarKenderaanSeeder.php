<?php

namespace Database\Seeders;

use App\Models\FleetPlacement;
use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\DaftarKenderaanMigrate;
use App\Models\Kenderaan\Maklumat;
use App\Models\Kenderaan\MaklumatTambahan;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\Kenderaan\StatusSemakan;
use App\Models\Location\Negeri;
use App\Models\Location\Placement;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DaftarKenderaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function kenderaanStatus($const)
    {
        $status = KenderaanStatus::where('code',$const)->first();

        return $status->id;
    }

    public function run()
    {
        $listMigrate = DaftarKenderaanMigrate::limit(5)->get();

        // $listMigrate = DaftarKenderaanMigrate::all();

        // 'no_pendaftaran',
        // 'hakmilik',
        // 'negeri',
        // 'pemilik',
        // 'lokasi_penempatan',
        // 'id_pemunya',
        // 'kategori',
        // 'sub_kategori',
        // 'jenis',
        // 'pembuat',
        // 'model',
        // 'no_jkr',
        // 'no_loji',
        // 'no_enjin',
        // 'no_chasis',
        // 'status',
        // 'harga_perolehan',
        // 'jenis_perolehan',
        // 'tarikh_perolehan'

        ini_set('memory_limit', '512M');

        foreach ($listMigrate as $key) {

            $negeri = $key->negeri;
            $state = Negeri::select('id','negeri')->whereRaw("upper(negeri) LIKE '%".$negeri."%' ")
            ->first();

            $stateId = null;
            if(!empty($state)){
                $stateId = $state->id;
            } else {

                Log::info('samae x ? '.strtoupper($negeri));

                Log::info('dengan x ? W.P. LABUAN');

                if(strtoupper($negeri) == 'W.P. LABUAN'){
                    $search = 'Wilayah Persekutuan Labuan';
                    $state = Negeri::select('id','negeri')->whereRaw("upper(negeri) = '".strtoupper($search)."' ")
                    ->first();
                    $stateId = $state->id;
                }
            }

            $pemilik = $key->pemilik;
            $owner = RefOwner::select('id','name')->whereRaw("upper(name) ='".$pemilik."' ")
            ->first();

            $lokasi_penempatan = $key->lokasi_penempatan;
            $placement = FleetPlacement::select('id','name')->whereRaw("upper(name) ='".$lokasi_penempatan."' ")
            ->first();

            $pendaftaran_id = Pendaftaran::create([
                'no_pendaftaran' => $key->no_pendaftaran,
                'hak_milik' => $key->hakmilik,
                'state_id' => $stateId,
                'created_by' => $owner ? $owner->id : null,
                'placement_id' => $placement ? $placement->id : null,
                'no_jkr' => $key->no_jkr,
            ])->id;

            $kategori = $key->kategori;
            $category = RefCategory::select('id','name')->whereRaw("upper(name) ='".$kategori."' ")
            ->first();

            $sub_kategori = $key->sub_kategori;
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

            Log::info('return $pendaftaran_id --> '.$pendaftaran_id);

            Maklumat::create([
                'pendaftaran_id' => $pendaftaran_id,
                'category_id' => $category ? $category->id : null,
                'sub_category_id' => $sub_category ? $sub_category->id : null,
                'sub_category_type_id' => $sub_category_type ? $sub_category_type->id :null,
                'brand_id' => $vehicleBrand ? $vehicleBrand->id : null,
                'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);

            StatusSemakan::create([
                'pendaftaran_id' => $pendaftaran_id,
                'vapp_status_id' => $this->kenderaanStatus('06')
            ]);

            // Maklumat::create([
            //     'pendaftaran_id' => $pendaftaran->id,
            //     'no_pendaftaran' => $key->no_pendaftaran,
            //     'hak_milik' => $key->hakmilik,
            //     'negeri' => $key->negeri
            // ]);

            // MaklumatTambahan::create([
            //     'pendaftaran_id' => $pendaftaran->id,
            //     'no_pendaftaran' => $key->no_pendaftaran,
            //     'hak_milik' => $key->hakmilik,
            //     'negeri' => $key->negeri
            // ]);
        }

    }
}
