<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DdColumnMKSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saman.maklumat_saman', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('cawangan_id');
            $table->string('jenis_saman')->nullable()->after('created_by');
            $table->foreign('created_by')->references('id')->on('users.users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saman.maklumat_saman');
    }
}
