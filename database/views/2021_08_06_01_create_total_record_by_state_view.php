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

class CreateTotalRecordByStateView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    DB::statement("
      CREATE VIEW fleet.total_record_by_state_view AS
      (
        select rs.code, rs.\"desc\" as state_name,count(fd.state_id) as total_by_state from fleet.fleet_department fd inner join
        ref_state rs on fd.state_id=rs.id group by fd.state_id,rs.\"desc\",rs.code order by rs.code
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
        Schema::dropViewIfExists('fleet.total_record_by_state_view');
    }
}
