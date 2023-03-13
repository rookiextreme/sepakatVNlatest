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

class CreateFleetDisposalView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    DB::statement("
    CREATE VIEW fleet.fleet_disposal_view AS (
        select \"fd\".\"no_pendaftaran\" as \"NO.PENDAFTARAN\",
        \"rot\".\"desc_bm\" as \"HAK MILIK\",
        \"rs\".\"desc\" as \"NEGERI\",
        \"ro\".\"name\" as \"CAWANGAN\",
        \"fp\".\"desc\" as \"LOKASI PENEMPATAN\",
        \"rc\".\"name\" as \"KATEGORI\",
        \"rsc\".\"name\" as \"SUB KATEGORI\",
        \"rsct\".\"name\" as \"JENIS\",
        \"vb\".\"name\" as \"PEMBUAT\",
        \"vm\".\"name\" as \"MODEL\",
        \"no_chasis\" as \"NO.CASIS\",
        \"no_engine\" as \"NO.ENJIN\",
        \"fd\".\"no_id_pemunya\" as \"NO.ID PEMUNYA\",
        \"fd\".\"no_loji\" as \"NO.LOJI\",
        \"fd\".\"no_jkr\" as \"NO.JKR\",
        \"harga_perolehan\" as \"HARGA PEROLEHAN\",
        \"acqDt\" as \"TARIKH PEROLEHAN\",
        \"tarikh_cukai_jalan\" as \"TARIKH CUKAI JALAN\",
        \"fd\".\"tarikh_pembelian_kenderaan\" as \"TARIKH PEMBELIAN\" ,
        \"tarikh_pemeriksaan_keselamatan\" as \"TARIKH PEMERIKSAAN KESELAMATAN\",
        \"manufacture_year\" as \"TAHUN DIBUAT\",
        \"us\".\"name\" as \"PEGAWAI BERTANGGUNGJAWAB\",
        \"usr\".\"name\" as \"PEGAWAI KEMASKINI\",
        \"tarikh_kemaskini\" as \"TARIKH KEMASKINI\",
        \"rvs\".\"desc\" as \"STATUS\",
        \"rdi\".\"desc\" as \"KAEDAH PELUPUSAN\",
        \"no_resit\" as \"NO.RESIT RASMI\",
        \"pembeli\" as \"PEMBELI\",
        \"dispose_dt\" as \"TARIKH PELUPUSAN\"
        from \"fleet\".\"fleet_disposal\" as \"fd\"
        left join \"ref_owner_type\" as \"rot\" on \"fd\".\"owner_type_id\" = \"rot\".\"id\"
        left join \"ref_state\" as \"rs\" on \"fd\".\"state_id\" = \"rs\".\"id\"
        left join \"ref_owner\" as \"ro\" on \"fd\".\"cawangan_id\" = \"ro\".\"id\"
        left join \"fleet\".\"fleet_placement\" as \"fp\" on \"fd\".\"placement_id\" = \"fp\".\"id\"
        left join \"ref_category\" as \"rc\" on \"fd\".\"category_id\" = \"rc\".\"id\"
        left join \"ref_sub_category\" as \"rsc\" on \"fd\".\"sub_category_id\" = \"rsc\".\"id\"
        left join \"ref_sub_category_type\" as \"rsct\" on \"fd\".\"sub_category_type_id\" = \"rsct\".\"id\"
        left join \"vehicles\".\"brands\" as \"vb\" on \"fd\".\"brand_id\" = \"vb\".\"id\"
        left join \"vehicles\".\"vehicle_models\" as \"vm\" on \"fd\".\"model_id\" = \"vm\".\"id\"
        left join \"ref_vehicle_status\" as \"rvs\" on \"fd\".\"vehicle_status_id\" = \"rvs\".\"id\"
        left join \"users\".\"users\" as \"us\" on \"fd\".\"person_incharge_id\" = \"us\".\"id\"
        left join \"users\".\"users\" as \"usr\" on \"fd\".\"updated_by\" = \"usr\".\"id\"
        left join \"ref_disposal\" as \"rdi\" on \"fd\".\"disposal_id\" = \"rdi\".\"id\"
        )
    ");
    }
    // \\\"no_lo\\\" as \\\"NO LO\\\",
    // \\\"tarikh_pemeriksaan_fizikal\\\",
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('fleet.fleet_disposal_view');
    }
}
