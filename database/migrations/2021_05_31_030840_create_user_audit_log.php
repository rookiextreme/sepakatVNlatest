<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAuditLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users.user_audit_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ref_status_id');
            $table->unsignedBigInteger('action_by');
            $table->foreign('user_id')->references('id')->on('users.users');
            $table->foreign('ref_status_id')->references('id')->on('ref_status');
            $table->foreign('action_by')->references('id')->on('users.users');
            $table->string('comment');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('users.user_audit_log');
    }
}
