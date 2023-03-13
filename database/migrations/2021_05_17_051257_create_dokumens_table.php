<?php

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kenderaans.dokumens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_department_id')->nullable();
            $table->unsignedBigInteger('fleet_public_id')->nullable();
            $table->unsignedBigInteger('fleet_disposal_id')->nullable();
            $table->unsignedBigInteger('fleet_grant_id')->nullable();
            $table->string('doc_type');
            $table->string('doc_path');
            $table->string('doc_path_thumbnail')->nullable();
            $table->string('doc_name');
            $table->string('doc_desc')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->foreign('fleet_department_id', 'fleet_department_id_foreign')->references('id')->on('fleet.fleet_department');
            $table->foreign('fleet_public_id', 'fleet_public_id_foreign')->references('id')->on('fleet.fleet_public');
            $table->foreign('fleet_disposal_id', 'fleet_disposal_id_foreign')->references('id')->on('fleet.fleet_disposal');
            $table->foreign('fleet_grant_id', 'fleet_grant_id_foreign')->references('id')->on('fleet.fleet_grant');
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
        Schema::dropIfExists('kenderaans.dokumens');
    }
}
