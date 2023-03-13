<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_status', function (Blueprint $table) {
            $table->id();
            $table->string('code',10);
            $table->string('desc_bm',50);
            $table->string('desc_en',50);
            $table->timestamp('created_at') -> useCurrent();
            $table->timestamp('updated_at') -> useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_status');
    }
}
