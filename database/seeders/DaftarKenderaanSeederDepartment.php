<?php

namespace Database\Seeders;

use App\Models\Fleet\FleetDepartment;
use App\Models\FleetPlacement;
use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\DaftarKenderaanMigrate;
use App\Models\Kenderaan\Maklumat;
use App\Models\Kenderaan\MaklumatTambahan;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\Kenderaan\StatusSemakan;
use App\Models\Location\Negeri;
use App\Models\Location\Placement;
use App\Models\RefBranch;
use App\Models\RefCategory;
use App\Models\RefDivision;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefSector;
use App\Models\RefState;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefTableType;
use App\Models\RefVehicleStatus;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Expr\Cast\Double;
use Illuminate\Support\Str;

class DaftarKenderaanSeederDepartment extends Seeder
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
        //  $listMigrate = DaftarKenderaanMigrate::limit(100)->get();
        $hasDoubleDotsArray = [];

        if(env('SMALL_MIGRATE')){
            $listMigrate = DaftarKenderaanMigrate::limit(100)->get();
        } else {
            $listMigrate = DaftarKenderaanMigrate::all();
        }

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

        ini_set('memory_limit', '800M');

        foreach ($listMigrate as $key) {

            $negeri = $key->negeri;
            $state = RefState::select('id','desc')->whereRaw("upper(\"desc\") LIKE '%".$negeri."%'")
            ->first();


            $stateId = null;
            if(!empty($state)){
                $stateId = $state->id;
            } else {

                Log::info('samae x ? '.strtoupper($negeri));

                Log::info('dengan x ? W.P. LABUAN');

                if(strtoupper($negeri) == 'W.P. LABUAN'){
                    $search = 'WP LABUAN';
                    $state = RefState::select('id','desc')->whereRaw("upper(\"desc\") = '".strtoupper($search)."' ")
                    ->first();
                    $stateId = $state->id;
                }
                if(strtoupper($negeri) == 'WILAYAH PERSEKUTUAN KUALA LUMPUR'){
                    $search = 'WP KUALA LUMPUR';
                    $state = RefState::select('id','desc')->whereRaw("upper(\"desc\") = '".strtoupper($search)."' ")
                    ->first();
                    $stateId = $state->id;
                }
                if(strtoupper($negeri) == 'WILAYAH PERSEKUTUAN PUTRAJAYA'){
                    $search = 'WP PUTRAJAYA';
                    $state = RefState::select('id','desc')->whereRaw("upper(\"desc\") = '".strtoupper($search)."' ")
                    ->first();
                    $stateId = $state->id;
                }
            }



            $pemilik = $key->pemilik;
            if(!empty($stateId)){
            $owner_cawangan = RefOwner::select('id','name')->whereRaw("upper(name) like '".$pemilik."%'")
            ->first();
            }

            $lokasi_penempatan = $key->lokasi_penempatan;
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
            Log::info("After>>".ltrim($lokasi_penempatan));
            $placement = FleetPlacement::select('id','desc')->whereRaw("upper(\"desc\") ='".ltrim($lokasi_penempatan)."' ")
            ->first();


            $kategori = $key->kategori;
            if($kategori == 'KENDERAAN'){
                $kategori = 'KENDERAAN PENUMPANG';
            }
            $category = RefCategory::select('id','name')->whereRaw("upper(name) ='".$kategori."' ")
            ->first();

            $sub_kategori = $key->sub_kategori;
            $sub_category = RefSubCategory::select('id','name')->whereRaw("upper(name) ='".$sub_kategori."' ")
            ->first();

            $jenis = $key->jenis;
            if($jenis == 'LORI PIKAP'){
                $jenis = 'LORI PIKAP (PICK-UP)';
            }
            $sub_category_type = RefSubCategoryType::select('id','name')->whereRaw("upper(name) ='".$jenis."' ")
            ->first();

            $brandName = $key->pembuat;
            $vehicleBrand = Brand::select('id','name')->whereRaw("upper(name) ='".$brandName."' ")
            ->first();

            $modelName = $key->model;
            $vehicleModel = VehicleModel::select('id','name')->whereRaw("upper(name) ='".$modelName."' ")
            ->first();

            $vstatus = Str::upper($key->status);
            Log::info("statuss ".$vstatus);
            $vehicleStatus = RefVehicleStatus::select('id','desc')->whereRaw(" \"desc\" ='".$vstatus."' ")
            ->first();

            Log::info('$key->harga_perolehan -->'.$key->harga_perolehan);

            $regexString = "/\d.*\d/";
            $removeString = preg_replace($regexString, '', $key->harga_perolehan);

            $hasDoubleDott = preg_match('/\..*\./',$removeString);
            $hasDoubleCommaa = preg_match('/\,.*\,/',$removeString);

            $regextDott = "/[.,]/";

            if($hasDoubleDott == 1 || $hasDoubleCommaa == 1){
                Log::info('no_pendaftaran --> '.$key->no_pendaftaran);
                Log::info('has hasDoubleDott / has hasDoubleCommaa -->'.$removeString);

                array_push($hasDoubleDotsArray, $removeString);
                $afterMassage = preg_replace($regextDott, '', substr($removeString, 0, -2));
            }  else {
                $afterMassage = $removeString;
            }

            $regexNumber = "/\d+?/";
            $isNumber = preg_match($regexNumber, $afterMassage);

            Log::info('isNumber -->'.$isNumber);
            Log::info('afterMassage -->'.$afterMassage);

            $stateId = null;
            if(!empty($state)){
                $stateId = $state->id;
            } else {

                Log::info('samae x ? '.strtoupper($negeri));

                Log::info('dengan x ? W.P. LABUAN');

                if(strtoupper($negeri) == 'W.P. LABUAN'){
                    $search = 'WP LABUAN';
                    $state = RefState::select('id','desc')->whereRaw("upper(\"desc\") = '".strtoupper($search)."' ")
                    ->first();
                    $stateId = $state->id;
                }
                if(strtoupper($negeri) == 'WILAYAH PERSEKUTUAN KUALA LUMPUR'){
                    $search = 'WP KUALA LUMPUR';
                    $state = RefState::select('id','desc')->whereRaw("upper(\"desc\") = '".strtoupper($search)."' ")
                    ->first();
                    $stateId = $state->id;
                }
                if(strtoupper($negeri) == 'WILAYAH PERSEKUTUAN PUTRAJAYA'){
                    $search = 'WP PUTRAJAYA';
                    $state = RefState::select('id','desc')->whereRaw("upper(\"desc\") = '".strtoupper($search)."' ")
                    ->first();
                    $stateId = $state->id;
                }
            }

            if ($key->hakmilik == 'PERSEKUTUAN'){
                $hakmilikSmall = 'persekutuan';
            } else if ($key->hakmilik == 'NEGERI'){
                $hakmilikSmall = 'negeri';
            } else if ($key->hakmilik == 'KONTRAKTOR (PROJEK)'){
                $hakmilikSmall = 'projek';
            }

            $hakmilik = $key->hakmilik;
            $ownerType = RefOwnerType::select('id','desc_bm')->whereRaw("upper(\"desc_bm\") LIKE '%".$hakmilik."%'")
            ->where([
                'display_for' => 'vehicle_register'
            ])
            ->first();

            if(!empty($ownerType)){
                $ownerTypeId = $ownerType->id;
            }

            FleetDepartment::create([
                'no_pendaftaran' => $key->no_pendaftaran,
                'owner_type_id' => $ownerTypeId,
                'state_id' => $stateId,
                'cawangan_id' => $owner_cawangan ? $owner_cawangan->id : null,
                // 'created_by' => $owner ? $owner->id : null,
                'placement_id' => $placement ? $placement->id : null,
                'no_jkr' => $key->no_jkr,
                'no_loji' => $key->no_loji,
                'no_engine' => $key->no_enjin,
                'no_chasis' => $key->no_chasis,
                'category_id' => $category ? $category->id : null,
                'sub_category_id' => $sub_category ? $sub_category->id : null,
                'sub_category_type_id' => $sub_category_type ? $sub_category_type->id :null,
                'brand_id' => $vehicleBrand ? $vehicleBrand->id : null,
                'model_id' => $vehicleModel ? $vehicleModel->id : null,
                'vapp_status_id' => $this->kenderaanStatus('06'),
                'vehicle_status_id' => $vehicleStatus ? $vehicleStatus->id : null,
                'acqDt' => $key->tarikh_perolehan ? Carbon::parse($key->tarikh_perolehan)->format('Y-m-d') : null,
                'manufacture_year' => $key->tarikh_perolehan ? Carbon::parse($key->tarikh_perolehan)->format('Y') : null,
                'harga_perolehan' => $isNumber == 1 && $afterMassage ? bcadd($afterMassage,'0',2) : null,
                'no_id_pemunya' => $key->id_pemunya,
            ])->id;
        }

        // $platnumbers = ["AAN7975","JLS1949","JLS1952","JRN3272","WPL2172"];
        $platnumbers =[ "WWE3153","BAX4876","WTF3225","WDQ4732","WSD1831","WTF3177","WBG1527","WTE8557","WCC5735","WTF3264","WWB7353","WHY4078","WCV5477",
"WTE8594","WTE8596","WCV3647","WDC5574","WDS8349","LA6326","LA7511","LA8258","SAA1495B","SAA3432M","SAB7323G","SAB8194A","SAB8196A",
"WDA9693","WLH8247","WWE3671","JQL6030","DDC7329","NCK3790","CBH2004","BLN2194","BLN4562","BLN4506","TAK6951","TAK7855",
"TAN8906","TAQ7817","TV3601","TV3608","TAK6948","TM1754","TAX6185","TAX3384","TAX3391","TBP8955","TAK7852","TAK9154",
"TAK6946","TAK7851","TAK7853","TAK7854","TAM3289","TAN8428","TAN8432","TAP7363","TAX3392","TAK8712","TAN6726","TAP2514",
"TAX1396","TBA4035","TM4607","TAX3390","JLS1949","JLS1952","JRN3272","WCC5679","DBB2116","DT3895","WCC5733","WJS2028",
"JGT6617","JQN9465","BAX9238","KDW321","WCM7573","DCV1214","MAT675","MBF9506","NBJ5218","WBV7141","WDD2095","WDR8507",
"CAA7915","CAC3947","CAC3949","CAG6242","CAW896","CAX4544","CBE7911","WBM356","WJT404","AEJ9411","AGD9011","AJN939","WBY978",
"WTE8572","RH9895","RN373","WBP310","DAQ709","WCS9556","WSD2422","WCT1466","BEG6307","BLM7357","BLM7367","BLM7397","BLN2165",
"BLN4021","WER8462","LA2358","SAB7321G","TAG9080","TAK3766","TAK6944","TAK6945","TAK8719","TAN8431","TAN8435","TAQ7032",
"TN9550","WCB2083","WDD2086","WCC6037","TAK7849" ];
        $query = FleetDepartment::whereIn('no_pendaftaran', $platnumbers);
        $query->update([
            'disaster_ready' => true
        ]);

        Log::info('hasDoubleDotsArray');
        Log::info($hasDoubleDotsArray);

    }
}
