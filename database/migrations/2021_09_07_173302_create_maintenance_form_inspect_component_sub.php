<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceFormInspectComponentSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.form_inspect_component_sub', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ins_comp_id')->nullable();
            $table->foreign('ins_comp_id')->references('id')->on('maintenance.form_inspect_component');

            $table->tinyInteger('lvl');

            $table->unsignedBigInteger('comp_lvl2_id')->nullable();
            $table->foreign('comp_lvl2_id')->references('id')->on('ref_component_lvl2');

            $table->unsignedBigInteger('comp_lvl3_id')->nullable();
            $table->foreign('comp_lvl3_id')->references('id')->on('ref_component_lvl3');

            $table->string('title', 100)->nullable();
            $table->string('sub_title', 100)->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price', 50)->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

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
        Schema::dropIfExists('maintenance.form_inspect_component_sub');
    }
}
