<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceEvaluationFormcheckDoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.evaluation_formcheck_doc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('doc_type',50)->nullable();
            $table->string('category',50)->nullable();
            $table->string('doc_format',50)->nullable();
            $table->string('doc_path')->nullable();
            $table->string('doc_name',100)->nullable();
            $table->string('doc_path_thumbnail')->nullable();
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
        Schema::dropIfExists('maintenance.evaluation_formcheck_doc');
    }
}
