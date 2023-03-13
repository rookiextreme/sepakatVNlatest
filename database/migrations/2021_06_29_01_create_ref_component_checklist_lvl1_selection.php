<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefComponentChecklistLvl1Selection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_component_checklist_lvl1_selection', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ref_component_checklist_lvl1_id')->nullable();
            $table->foreign('ref_component_checklist_lvl1_id')->references('id')->on('ref_component_checklist_lvl1');

            $table->unsignedBigInteger('table_selection_id')->nullable();
            $table->foreign('table_selection_id')->references('id')->on('ref_table_selection');

            $table->unsignedBigInteger('selection_id')->nullable();
            $table->foreign('selection_id')->references('id')->on('ref_selection');
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
        Schema::dropIfExists('ref_component_checklist_lvl1_selection');
    }
}
