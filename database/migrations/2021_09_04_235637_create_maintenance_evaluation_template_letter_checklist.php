<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceEvaluationTemplateLetterCheckList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('maintenance.evaluation_template_letter_checklist', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('template_letter_type_id')->nullable();
            $table->foreign('template_letter_type_id')->references('id')->on('maintenance.evaluation_letter_type');
            
            $table->unsignedBigInteger('evaluation_template_letter_id')->nullable();
            $table->foreign('evaluation_template_letter_id')->references('id')->on('maintenance.evaluation_template_letter');

            $table->string('job_detail')->nullable();
            $table->string('syntom')->nullable();
            $table->string('accessories')->nullable();
            $table->double('budget')->nullable();

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
        Schema::dropIfExists('maintenance.evaluation_template_letter_checklist');
    }
}
