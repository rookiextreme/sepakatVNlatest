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

class CreateMaintenanceInOutRepairReport2021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    DB::statement("
      CREATE VIEW maintenance.maintenance_inout_repair_report_2021 AS
      (
        SELECT
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 1 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_1,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 2 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_2,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 3 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_3,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 4 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_4,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 5 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_5,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 6 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_6,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 7 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_7,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 8 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_8,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 9 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_9,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 10 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_10,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 11 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_11,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%1%' and EXTRACT(MONTH FROM jvf.created_at) = 12 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_internal_repair_12,

        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 1 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_1,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 2 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_2,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 3 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_3,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 4 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_4,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 5 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_5,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 6 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_6,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 7 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_7,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 8 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_8,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 9 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_9,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 10 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_10,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 11 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_11,
        ( select count(jvf.id) from maintenance.job_vehicle_examination_form jvf left join maintenance.job_vehicle jv on jvf.vehicle_id = jv.id where jv.maintenance_job_purpose_type = '2'  and jvf.repair_method like '%2%' and EXTRACT(MONTH FROM jvf.created_at) = 12 and EXTRACT(YEAR FROM jvf.created_at) = 2021 ) AS total_external_repair_12
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
        Schema::dropViewIfExists('maintenance.maintenance_inout_repair_report_2021');
    }
}
