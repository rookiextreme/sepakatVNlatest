<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateLetterEstimationContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::create('maintenance.template_letter_estimation_content', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('task_desc');
        //     $table->string('damage_simptom');
        //     $table->string('replacement_part_desc');
        //     $table->double('estimation');

        //     $table->unsignedBigInteger('template_letter_estimation_id')->nullable();
        //     $table->foreign('template_letter_estimation_id')->references('id')->on('maintenance.template_letter_estimation');

        //     $table->unsignedBigInteger('created_by')->nullable();
        //     $table->foreign('created_by')->references('id')->on('users.users');

        //     $table->unsignedBigInteger('updated_by')->nullable();
        //     $table->foreign('updated_by')->references('id')->on('users.users');



        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('maintenance.template_letter_estimation_content');
    }
}
