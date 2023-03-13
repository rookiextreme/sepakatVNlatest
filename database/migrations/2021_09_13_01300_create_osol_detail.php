<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsolDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.osol_detail', function (Blueprint $table) {
            $table->id();
            $table->string('osol',10)->nullable();

            $table->double('allocation')->nullable();
            $table->double('addition')->nullable();
            $table->double('deduct')->nullable();
            $table->double('total_allocation')->nullable();

            $table->double('expense')->nullable();
            $table->double('advance')->nullable();
            $table->double('total_expense')->nullable();

            $table->double('balance')->nullable();

            $table->double('percent_expense')->nullable();
            $table->double('percent_advance')->nullable();
            $table->double('percent_financial')->nullable()->comment('Utilize warrant');

            $table->tinyInteger('status')->default(1);

            $table->unsignedBigInteger('waran_type_id')->nullable();
            $table->foreign('waran_type_id')->references('id')->on('maintenance.waran_type');

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
        Schema::dropIfExists('maintenance.osol_detail');
    }
}
