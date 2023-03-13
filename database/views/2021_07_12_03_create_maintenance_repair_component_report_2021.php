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

class CreateMaintenanceRepairComponentReport2021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    DB::statement("
      CREATE VIEW maintenance.maintenance_repair_component_report_2021 AS
      (
        SELECT
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 2  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,
        35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50) and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_enjine_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 2 and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (117,118,119,120,121,122,123,124,125,126,127,128,129,130,131)
        and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_steering_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 2  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,339)
        and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_brake_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 2  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82)
        and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_transmission_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 2  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,
        211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242)
        and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_electronics_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 2  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (106,107,108,109,110,111,112,113,114,115,116)
        and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_acsystem_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 2  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (249,250,251,252,253,254,255,256,257,258)
        and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_tyre_12,

        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 1  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_1,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 2  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_2,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 3  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_3,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 4  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_4,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 5  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_5,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 6  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_6,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 7  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_7,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 8  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_8,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 9  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_9,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 10  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_10,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 11  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_11,
        (select count(id) from maintenance.mjob_exam_form_component_sub where comp_lvl2_id in (259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,
        283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319)
        and EXTRACT(MONTH FROM created_at) = 12  and EXTRACT(YEAR FROM created_at) = 2021 ) AS total_component_body_12
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
        Schema::dropViewIfExists('maintenance.maintenance_repair_component_report_2021');
    }
}
