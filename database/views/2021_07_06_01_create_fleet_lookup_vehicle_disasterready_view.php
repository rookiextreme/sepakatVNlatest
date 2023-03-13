<?php

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetPublic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;
use App\Models\Kenderaan\Pendaftaran;

class CreateFleetLookupVehicleDisasterReadyView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableTypeDepart = DB::raw("concat('department') as table_type");
        $queryDepartment = FleetDepartment::select($tableTypeDepart, 'id', 'user_id', 'no_pendaftaran','cawangan_id','owner_type_id','category_id',
        'sub_category_id','sub_category_type_id','person_incharge_id','no_chasis','no_engine','no_jkr','no_loji','acqDt','vapp_status_id','vehicle_status_id',
        'main_driver_id')->whereRaw('disaster_ready = true');

        // $tableTypePublic = DB::raw("concat('public') as table_type");
        // $queryPublic = FleetPublic::select($tableTypePublic, 'id', 'user_id', 'no_pendaftaran','cawangan_id','owner_type_id','category_id',
        // 'sub_category_id','sub_category_type_id','person_incharge_id','no_chasis','no_engine','no_jkr','no_loji','acqDt','vapp_status_id','vehicle_status_id',
        // 'main_driver_id' );

        Schema::createView('fleet.fleet_lookup_vehicle_disasterready_view', $queryDepartment);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('fleet.fleet_lookup_vehicle_disasterready_view');
    }
}
