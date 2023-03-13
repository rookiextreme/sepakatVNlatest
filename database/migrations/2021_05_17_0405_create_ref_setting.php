<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_setting', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable();
            $table->string('name',50)->nullable();
            $table->string('element_type',70)->nullable();
            $table->boolean('is_required')->default(true);
            $table->string('desc')->nullable(); //day week month
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
        Schema::dropIfExists('ref_setting');
    }
}
