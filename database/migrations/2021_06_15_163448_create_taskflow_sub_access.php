<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskflowSubAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taskflow_sub_access', function (Blueprint $table) {
            $table->id();
            $table->string('name_bm',100)->nullable();
            $table->string('name_en',100)->nullable();
            $table->string('desc_bm',100)->nullable();
            $table->string('desc_en',100)->nullable();

            $table->integer("mod_fleet_verify")->default(0);
            $table->integer("mod_fleet_appointment")->default(0);
            $table->integer("mod_fleet_approval")->default(0);
            $table->integer("mod_fleet_pass")->default(0);
            $table->integer("mod_fleet_can_edit_after_approve")->default(0);
            $table->integer("mod_fleet_can_dispose_federal")->default(0);
            $table->integer("mod_fleet_can_dispose_state")->default(0);

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');

            $table->unsignedBigInteger('taskflow_sub_id');
            $table->foreign('taskflow_sub_id')->references('id')->on('taskflow_sub');

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');

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
        Schema::dropIfExists('taskflow_sub_access');
    }
}
