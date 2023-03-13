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

class CreateMaintenanceServiceComponentReport2021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    DB::statement("
      CREATE VIEW maintenance.maintenance_service_component_report_2021 AS
      (
        SELECT
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 1 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 3 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 4 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 5 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 6 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 7 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 8 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 9 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 10 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 11 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (340,341,342,343,344,345,346,347,348) and EXTRACT(MONTH FROM created_at) = 12 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_enjine_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 1 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 3 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 4 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 5 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 6 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 7 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 8 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 9 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 10 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 11 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (349,350,351,352,353) and EXTRACT(MONTH FROM created_at) = 12 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_transmission_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 1 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 3 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 4 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 5 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 6 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 7 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 8 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 9 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 10 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 11 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 354 and EXTRACT(MONTH FROM created_at) = 12 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_steering_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 1 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 3 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 4 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 5 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 6 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 7 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 8 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 9 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 10 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 11 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 355 and EXTRACT(MONTH FROM created_at) = 12 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_brake_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 1 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 3 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 4 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 5 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 6 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 7 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 8 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 9 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 10 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 11 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (356,357,358,359) and EXTRACT(MONTH FROM created_at) = 12 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_tyre_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 1 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 3 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 4 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 5 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 6 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 7 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 8 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 9 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 10 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 11 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (360,361,362,363,364) and EXTRACT(MONTH FROM created_at) = 12 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_acsystem_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 1 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 3 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 4 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 5 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 6 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 7 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 8 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 9 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 10 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 11 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id = 365 and EXTRACT(MONTH FROM created_at) = 12 and EXTRACT(YEAR FROM created_at) = 2021) AS total_component_other_12
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
        Schema::dropViewIfExists('maintenance.maintenance_service_component_report_2021');
    }
}
