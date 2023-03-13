<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsolType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance.osol_type', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('value');
            $table->string('desc')->nullable();
            $table->integer('status')->default(1);

            $table->unsignedBigInteger('warrant_type_id')->nullable();
            $table->foreign('warrant_type_id')->references('id')->on('maintenance.waran_type');

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
        Schema::dropIfExists('maintenance.osol_type');
    }
}
