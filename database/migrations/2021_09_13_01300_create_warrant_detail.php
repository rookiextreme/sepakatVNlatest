<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.warrant_detail', function (Blueprint $table) {
            $table->id();
            $table->string('state',32)->nullable();

            $table->double('allocation')->nullable();
            $table->double('addition')->nullable();
            $table->double('deduct')->nullable();
            $table->double('total_allocation')->nullable();

            $table->double('expense')->nullable();
            $table->double('advance')->nullable();
            $table->double('total_expense')->nullable();
            $table->double('note_expense')->nullable();

            $table->double('balance')->nullable();

            $table->double('percent_expense')->nullable();
            $table->double('percent_advance')->nullable();
            $table->double('percent_financial')->nullable()->comment('Utilize warrant');

            $table->integer('status')->default(1);

            $table->integer('year')->default(2021);
            $table->integer('month')->default(12);

            $table->date('warrant_received_dt')->nullable();

            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->foreign('workshop_id')->references('id')->on('ref_workshop');

            $table->unsignedBigInteger('waran_type_id')->nullable();
            $table->foreign('waran_type_id')->references('id')->on('maintenance.waran_type');

            $table->unsignedBigInteger('osol_type_id')->nullable();
            $table->foreign('osol_type_id')->references('id')->on('maintenance.osol_type');

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
        Schema::dropIfExists('maintenance.warrant_detail');
    }
}
