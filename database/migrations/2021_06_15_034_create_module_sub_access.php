<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleSubAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_sub_access', function (Blueprint $table) {
            $table->id();
            $table->string('name_bm',100)->nullable();
            $table->string('name_en',100)->nullable();
            $table->string('desc_bm',100)->nullable();
            $table->string('desc_en',100)->nullable();

            $table->integer("mod_fleet_a")->default(0);
            $table->integer("mod_fleet_c")->default(0);
            $table->integer("mod_fleet_r")->default(0);
            $table->integer("mod_fleet_u")->default(0);
            $table->integer("mod_fleet_d")->default(0);
            $table->integer("mod_fleet_report")->default(0);
            $table->integer("fleet_has_limit")->default(0);
            $table->integer("mod_fleet_can_edit_after_approve")->default(0);
            $table->integer("mod_fleet_can_dispose_federal")->default(0);
            $table->integer("mod_fleet_can_dispose_state")->default(0);

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('module_sub_id');
            $table->foreign('module_sub_id')->references('id')->on('module_sub');

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('ref_role');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_sub_access');
    }
}
