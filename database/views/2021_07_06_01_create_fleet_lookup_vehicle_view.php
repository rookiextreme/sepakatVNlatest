<?php

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetPublic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;
use App\Models\Kenderaan\Pendaftaran;

class CreateFleetLookupVehicleView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableTypeDepart = DB::raw("concat('department') as table_type");
        $queryDepartment = FleetDepartment::select($tableTypeDepart, 'id', 'user_id', 'no_pendaftaran','cawangan_id','owner_type_id','placement_id','category_id','state_id',
        'sub_category_id','sub_category_type_id','brand_id','model_id','person_incharge_id','no_chasis','no_engine','no_jkr','no_loji','acqDt','vapp_status_id','vehicle_status_id',
        'main_driver_id','created_by' );

        $tableTypePublic = DB::raw("concat('public') as table_type");
        $queryPublic = FleetPublic::select($tableTypePublic, 'id', 'user_id', 'no_pendaftaran','cawangan_id','owner_type_id','placement_id','category_id','state_id',
        'sub_category_id','sub_category_type_id','brand_id','model_id','person_incharge_id','no_chasis','no_engine','no_jkr','no_loji','acqDt','vapp_status_id','vehicle_status_id',
        'main_driver_id','created_by' );

        // $queryUnion = DB::statement('SELECT id,no_pendaftaran,cawangan_id,hak_milik,category_id,
        // sub_category_id,sub_category_type_id from fleet.fleet_department UNION SELECT id,no_pendaftaran,cawangan_id,hak_milik,category_id,
        // sub_category_id,sub_category_type_id from fleet.fleet_public');

        // $combine = $queryDepartment->merge($queryPublic);
        // $combine = $queryDepartment->union($queryPublic)->get();
        Schema::createView('fleet.fleet_lookup_vehicle_view', $queryDepartment->union($queryPublic));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('fleet.fleet_lookup_vehicle_view');
    }
}
