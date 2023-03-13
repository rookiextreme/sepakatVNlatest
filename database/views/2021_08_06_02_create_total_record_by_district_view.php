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

class CreateTotalRecordByDistrictView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    DB::statement("
    CREATE VIEW fleet.total_record_by_district_view AS (
        select fp.code, fp.\"desc\" as district_name,count(fd.placement_id) as total_by_district, rs.\"desc\" as state_name from
        ((fleet.fleet_department fd
        inner join fleet.fleet_placement fp on fd.placement_id=fp.id)
        inner join ref_state rs on fd.state_id=rs.id) where fp.\"desc\" like 'JKR%'
        group by fd.placement_id,rs.\"desc\",fp.code,fp.\"desc\" order by rs.\"desc\"
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
        Schema::dropViewIfExists('fleet.total_record_by_district_view');
    }
}
