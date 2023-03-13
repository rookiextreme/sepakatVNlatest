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

class DaftarKenderaanSeederDepartmentUpdate extends Seeder
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

            Log::info('$key->harga_perolehan -->'.$key->harga_perolehan);
            Log::info('Nombor Plate -->'.$key->no_pendaftaran);
            // Log::info('harga -->'.$afterMassage);

            $query = FleetDepartment::where('no_pendaftaran', $key->no_pendaftaran);
            $query->update([
                    'harga_perolehan' => $key->harga_perolehan
                ]);
            }


    }
}
