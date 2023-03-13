<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet.fleet_department', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('cawangan_id')->nullable();
            $table->unsignedBigInteger('placement_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->string('no_pendaftaran')->nullable();
            $table->string('no_id_pemunya')->nullable();
            // $table->string('hak_milik')->nullable();
            $table->string('no_jkr')->nullable();

            $table->foreign('user_id')->references('id')->on('users.users');
            $table->foreign('state_id')->references('id')->on('ref_state');
            // $table->foreign('cawangan_id')->references('id')->on('locations.cawangans');
            // $table->foreign('cawangan_id')->references('id')->on('ref_division');
            $table->foreign('cawangan_id')->references('id')->on('ref_owner');
            $table->foreign('placement_id')->references('id')->on('fleet.fleet_placement');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('sub_category_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('no_chasis')->nullable();
            $table->string('no_engine')->nullable();
            $table->string('status')->nullable();
            $table->date('tarikh_belian')->nullable();
            $table->string('no_resit')->nullable();
            $table->string('pembeli')->nullable();

            $table->foreign('category_id')->references('id')->on('ref_category');
            $table->foreign('sub_category_id')->references('id')->on('ref_sub_category');
            $table->foreign('sub_category_type_id')->references('id')->on('ref_sub_category_type');
            $table->foreign('brand_id')->references('id')->on('vehicles.brands');
            $table->foreign('model_id')->references('id')->on('vehicles.vehicle_models');

            $table->unsignedBigInteger('vapp_status_id');
            $table->string('comment')->nullable();
            $table->foreign('vapp_status_id')->references('id')->on('identifiers.vapp_status');
            $table->timestamps();

            $table->string('no_loji')->nullable();
            $table->date('tarikh_cukai_jalan')->nullable();
            $table->double('harga_perolehan')->nullable();
            $table->date('tarikh_pembelian_kenderaan')->nullable();
            $table->string('no_lo')->nullable();
            $table->date('tarikh_pemeriksaan_fizikal')->nullable();
            $table->date('tarikh_pemeriksaan_keselamatan')->nullable();
            $table->year('manufacture_year')->nullable();
            $table->date('tarikh_kemaskini')->nullable();
            $table->date('acqDt')->nullable()->comment('acquisition');

            $table->unsignedBigInteger('ref_table_type_id')->nullable();
            $table->foreign('ref_table_type_id')->references('id')->on('ref_table_type');

            $table->unsignedBigInteger('vehicle_status_id')->nullable();
            $table->foreign('vehicle_status_id')->references('id')->on('ref_vehicle_status');

            $table->unsignedBigInteger('person_incharge_id')->nullable();
            $table->foreign('person_incharge_id')->references('id')->on('users.users');

            $table->unsignedBigInteger('main_driver_id')->nullable();
            $table->foreign('main_driver_id')->references('id')->on('users.users');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.users');

            // $table->unsignedBigInteger('owner_type_id')->nullable();
            // $table->foreign('owner_type_id')->references('id')->on('ref_owner_type');
            $table->foreignId('owner_type_id')->nullable()->constrained('ref_owner_type');

            $table->boolean('disaster_ready')->default(false);
            
            $table->boolean('is_maintenance')->default(false);
            $table->boolean('is_evaluation')->default(false);

            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('fleet.fleet_project');

            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('logistic.logistic_booking');

            $table->string('brand',100)->nullable();
            $table->string('model',100)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fleet');
    }
}
