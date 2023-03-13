<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefTableSelectionLvl2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_table_selection_lvl2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tbl_selection_id')->nullable();
            $table->foreign('tbl_selection_id')->references('id')->on('ref_table_selection');
            $table->string('code',10);
            $table->string('desc');
            $table->string('model');
            $table->string('table');
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
        Schema::dropIfExists('ref_table_selection_lvl2');
    }
}
