<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefComponentChecklistLvl2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_component_checklist_lvl2', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable();
            $table->unsignedBigInteger('id_component_checklist_lvl1')->nullable();
            $table->foreign('id_component_checklist_lvl1')->references('id')->on('ref_component_checklist_lvl1');
            $table->string('component')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('ref_component_checklist_lvl2');
    }
}
