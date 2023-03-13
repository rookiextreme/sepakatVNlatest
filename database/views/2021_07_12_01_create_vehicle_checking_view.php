<?php

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetPublic;
use App\Models\Identifier\KenderaanStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;
use App\Models\Kenderaan\Pendaftaran;

class CreateVehicleCheckingView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menunggu Semakan / Verifiation status for vehicle
        $verification = KenderaanStatus::where('code', '02')->first();
        $tableDepartment = 'fleet.fleet_department';
        $tablePublic = 'fleet.fleet_public';
        $summon = 'saman.maklumat_kenderaan_saman';

        $tableTypeDepart = DB::raw("concat('department') as table_type");
        $queryDepartment = FleetDepartment::select($tableTypeDepart,'fleet.fleet_department.id AS id','no_pendaftaran as plat_number','cawangan_id','ref_owner_type.desc_bm AS ownership','fleet.fleet_department.category_id AS category_id',
        'ref_category.name AS category_name','person_incharge_id','fleet.fleet_department.brand_id AS brand_id','fleet.fleet_department.model_id AS model_id',
        'vehicles.vehicle_models.name AS model_name','vehicles.brands.name AS brand_name',
        'locations.placement.name AS placement_name',
        'fleet.fleet_department.acqDt AS acqDt',
        'fleet.fleet_department.created_by AS created_by',
        DB::raw('(SELECT COUNT(*) FROM '.$summon.' WHERE '.$summon.'.pendaftaran_id = '.$tableDepartment.'.id) as total_summon' ))
        ->where(['vapp_status_id' => $verification->id])
        ->leftJoin('ref_category', 'ref_category.id', '=', 'category_id')
        ->leftJoin('vehicles.brands', 'vehicles.brands.id', '=', 'brand_id')
        ->leftJoin('vehicles.vehicle_models', 'vehicles.vehicle_models.id', '=', 'model_id')
        ->leftJoin('locations.placement', 'locations.placement.id', '=', 'fleet.fleet_department.placement_id')
        ->leftJoin('ref_owner_type', 'ref_owner_type.id', '=', 'fleet.fleet_department.owner_type_id');

        $tableTypePublic = DB::raw("concat('public') as table_type");
        $queryPublic = FleetPublic::select($tableTypePublic, 'fleet.fleet_public.id AS id','no_pendaftaran as plat_number','cawangan_id','ref_owner_type.desc_bm AS ownership','fleet.fleet_public.category_id AS category_id',
        'ref_category.name AS category_name','person_incharge_id','fleet.fleet_public.brand_id AS brand_id','fleet.fleet_public.model_id AS model_id',
        'vehicles.vehicle_models.name AS model_name','vehicles.brands.name AS brand_name',
        'locations.placement.name AS placement_name',
        'fleet.fleet_public.acqDt AS acqDt',
        'fleet.fleet_public.created_by AS created_by',
        DB::raw('(SELECT COUNT(*) FROM '.$summon.' WHERE '.$summon.'.pendaftaran_id = '.$tablePublic.'.id) as total_summon' ))
        ->where(['vapp_status_id' => $verification->id])
        ->leftJoin('ref_category', 'ref_category.id', '=', 'category_id')
        ->leftJoin('vehicles.brands', 'vehicles.brands.id', '=', 'brand_id')
        ->leftJoin('vehicles.vehicle_models', 'vehicles.vehicle_models.id', '=', 'model_id')
        ->leftJoin('locations.placement', 'locations.placement.id', '=', 'fleet.fleet_public.placement_id')
        ->leftJoin('ref_owner_type', 'ref_owner_type.id', '=', 'fleet.fleet_public.owner_type_id');

        Schema::createView('fleet.checking_vehicle_view', $queryDepartment->union($queryPublic));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('fleet.checking_vehicle_view');
    }
}
