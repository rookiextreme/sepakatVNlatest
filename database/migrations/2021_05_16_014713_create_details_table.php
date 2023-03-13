<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users.details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('identity_type_id')->nullable();
            $table->string('identity_no',20)->nullable();
            $table->string('telpejabat',20)->nullable();
            $table->string('telbimbit',20)->nullable();
            $table->string('company_name')->nullable();
            $table->string('register_purpose')->nullable();
            $table->string('doc_image_path')->nullable();
            $table->string('doc_signature_path')->nullable();
            $table->string('doc_image')->nullable();
            $table->string('doc_signature')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode',10)->nullable();
            $table->string('department_name')->nullable();

            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('ref_state');

            $table->unsignedBigInteger('agency_id')->nullable();
            $table->foreign('agency_id')->references('id')->on('ref_agency');

            $table->foreign('user_id')->references('id')->on('users.users');
            $table->foreign('identity_type_id')->references('id')->on('identifiers.identity_types');

            $table->unsignedBigInteger('ref_status_id');
            $table->foreign('ref_status_id')->references('id')->on('ref_status');

            $table->string('comment_status')->default('');

            $table->unsignedBigInteger('ref_role_id')->nullable();
            $table->foreign('ref_role_id')->references('id')->on('ref_role');
            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->foreign('workshop_id')->references('id')->on('ref_workshop');

            $table->unsignedBigInteger('placement_id')->nullable();

            // $table->foreign('placement_id')->references('id')->on('fleet.fleet_placement');

            $table->unsignedBigInteger('owner_type_id')->nullable();
            $table->foreign('owner_type_id')->references('id')->on('ref_owner_type');

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('ref_owner');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users.details');

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
        Schema::dropIfExists('users.jkr_staff');
        Schema::dropIfExists('users.details');
    }
}
