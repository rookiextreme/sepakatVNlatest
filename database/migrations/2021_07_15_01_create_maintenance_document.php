<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.document', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('doc_type')->nullable();
            $table->string('doc_format')->nullable();
            $table->string('doc_path')->nullable();
            $table->string('doc_name')->nullable();
            $table->tinyInteger('is_primary')->default(0);

            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('maintenance.document');
    }
}
