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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateGeneralRecordCountView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $verification = KenderaanStatus::where('code', '02')->first();
        // $countToVerify = DB::raw(" count(*) as total_vehicle_toverify ");
        // $queryCountVerifyDepartment = FleetDepartment::select($countToVerify)->where(['vapp_status_id' => $verification->id]);
        // $queryCountVerifyPublic = FleetDepartment::select($countToVerify)->where(['vapp_status_id' => $verification->id]);

        // $validation = KenderaanStatus::where('code', '03')->first();
        // $countToValidate = DB::raw(" count(*) as total_vehicle_tovalidate ");
        // $queryCountValidationDepartment = FleetDepartment::select($countToValidate)->where(['vapp_status_id' => $validation->id]);
        // $queryCountValidationPublic = FleetDepartment::select($countToValidate)->where(['vapp_status_id' => $validation->id]);

        // $queryAll = $queryCountVerifyDepartment->union($queryCountVerifyPublic)->union($queryCountValidationDepartment)->union($queryCountValidationPublic);
        // Schema::createView('fleet.general_record_count_view', $queryAll    );

        // $queryAll = DB::raw("select count(*) as total_vehicle_toverify from fleet.fleet_department where vapp_status_id=2
        // UNION
        // select count(*) as total_vehicle_tovalidate from fleet.fleet_public where vapp_status_id=2 ");
        // Schema::createView('fleet.general_record_count_view', $queryAll->get() );

    DB::statement("
      CREATE VIEW general_record_count_view AS
      (
        SELECT
        (SELECT COUNT(id) FROM fleet.fleet_department where vapp_status_id in (2,3) ) AS total_new_department,
        (SELECT COUNT(id) FROM fleet.fleet_department where vehicle_status_id in (1,2,3)) AS total_department_active,
        (SELECT COUNT(id) FROM fleet.fleet_department where vapp_status_id=2) AS total_department_vehicle_toverify,
        (SELECT COUNT(id) FROM fleet.fleet_public where vapp_status_id=2) AS total_public_vehicle_toverify,
		(SELECT COUNT(id) FROM fleet.fleet_department where vapp_status_id=3) AS total_department_vehicle_tovalidate,
        (SELECT COUNT(id) FROM fleet.fleet_public where vapp_status_id=3) AS total_public_vehicle_tovalidate,
		(SELECT COUNT(id) FROM saman.maklumat_kenderaan_saman where status_saman_id=2) AS total_summon_pending_payment,
		(SELECT COUNT(id) FROM saman.maklumat_kenderaan_saman where status_saman_id=4) AS total_summon_settle_payment,
		(SELECT COUNT(id) FROM users.details where ref_status_id=3) AS total_new_user,
		(SELECT COUNT(id) FROM users.details where ref_status_id=6) AS total_registered_user,
        (SELECT COUNT(id) FROM fleet.fleet_department where disaster_ready is true) AS total_vehicle_disaster_ready,
        (SELECT COUNT(id) FROM logistic.logistic_booking) AS total_logistic_booking,
        (SELECT COUNT(id) FROM logistic.disasterready_booking where status_id != 1) AS total_disaster_ready,
        (SELECT COUNT(id) FROM fleet.fleet_department where owner_type_id = 3 and vehicle_status_id in (1,2,3)) AS total_vehicle_persekutuan,
        (SELECT COUNT(id) FROM fleet.fleet_department where owner_type_id = 4 and vehicle_status_id in (1,2,3)) AS total_vehicle_negeri,
        (SELECT SUM(total_expense) FROM maintenance.warrant_detail where waran_type_id = 1 and osol_type_id in (1,2) and year = 2021) AS total_expenses_mhpv,
        (SELECT SUM(allocation) FROM maintenance.warrant_detail where waran_type_id = 1 and osol_type_id in (1,2) and year = 2021) AS total_allocation_mhpv
      )
    ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('general_record_count_view');
    }
}
