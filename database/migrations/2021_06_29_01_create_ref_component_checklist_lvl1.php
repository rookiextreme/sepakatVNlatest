<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefComponentChecklistLvl1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_component_checklist_lvl1', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable();
            $table->string('component')->nullable();
            $table->string('component_shortname')->nullable();
            // $table->string('code_assessment')->nullable();
            $table->integer('status')->default(1);

            $table->boolean('has_selection')->default(false);

            $table->boolean('has_upload')->default(false);

            // $table->unsignedBigInteger('table_selection_id')->nullable();
            // $table->foreign('table_selection_id')->references('id')->on('ref_table_selection');

            // $table->unsignedBigInteger('selection_id')->nullable();
            // $table->foreign('selection_id')->references('id')->on('ref_selection');

            $table->unsignedBigInteger('assessment_type_id')->nullable();
            $table->foreign('assessment_type_id')->references('id')->on('assessment.assessment_type');

            $table->unsignedBigInteger('maintenance_type_id')->nullable();
            $table->foreign('maintenance_type_id')->references('id')->on('maintenance.type');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users.users');
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
        Schema::dropIfExists('ref_component_checklist_lvl1');
    }
}
